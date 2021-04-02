<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscriber;

class SubscriptionController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'url'   => 'required|url|max:250'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        Subscriber::create($request->all());
        $data = [
            'url'   => $request->url,
            'topic' => $request->topic
        ];

        return response()->json($data, 201);
        
    
    }

}
