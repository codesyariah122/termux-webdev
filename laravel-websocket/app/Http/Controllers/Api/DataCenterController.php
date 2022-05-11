<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Events\TestingEvent;
class DataCenterController extends Controller
{

     public function HeloEvent()
    {
        try{
             $context="Broadcasting Events using web sockets";
            $data = broadcast(new TestingEvent($context));
             return response()->json([
                'message'=>"New event broadcast !",
                'data'=>$context
             ]);
         }catch(Exception $e){
             return response()->json([
                 'message' => 'Error fetch data if no token'
             ], 401);
         }

    }
}