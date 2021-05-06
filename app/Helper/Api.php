<?php


namespace App\Helper;


class Api
{
        static function successResponse($data){
            return response()->json(['status'=>'success','data' => $data]);
        }
}
