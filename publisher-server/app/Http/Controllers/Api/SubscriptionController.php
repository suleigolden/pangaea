<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

        $data = [
            'url'   => $request->url,
            'topic' => $request->topic
        ];

        return response()->json($data, 201);
    }

}
