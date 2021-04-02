<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $data = [
            'topic' => $request->topic
        ];
        return response()->json($data, 201);
    }
}
