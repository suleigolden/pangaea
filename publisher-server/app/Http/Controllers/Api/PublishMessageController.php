<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscriber;
use App\Models\Publisher;

class PublishMessageController extends Controller
{
    /**
     * publish message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function publish(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                '*'   => 'required'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $validator->errors()
                ], 422);
            }
    
            $subscribers = Subscriber::where('topic', $request->topic)->get();
            $payload = '';
            if ($subscribers) {
                foreach ($subscribers as $subscriber) {
                    $payload = [
                        "topic" => $request->topic, "data"  => $request->all()
                    ];
                    $this->httpPost($subscriber->url,$payload);
                }
                
                $payload = [
                    'message'   =>  'Message send to '.count($subscribers).' Subscribers',
                    "data" => $request->all()
                ];
    
                $publish = new Publisher();
                $publish->topic =  $request->topic;
                $publish->object =  json_encode($payload);
                $publish->isPublished =  true;
                $publish->isDelivered =  true;
                $publish->save();
    
            }else{
    
                $payload = [
                    'message'   => count($subscribers) .' Subscribers were notified'.$request->topic
                ];
            }
    
            return response()->json($payload, 201);
        } catch (\JsonException $e) {
            return response()->json([], 400);
        }
    }

public function httpPost($url, $data){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
