<?php


namespace App\Helper;


use App\Exceptions\ApiValidationException;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Token;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;
use Validator;


class Validation
{


    static function validateRequest($request, $rules)
    {
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            throw new ApiValidationException($validator->messages());
        }
    }

}
