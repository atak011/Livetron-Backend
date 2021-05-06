<?php


namespace App\Helper;



use Laravel\Passport\Token;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;


class Security
{

    static function obtainUserIdFromRequest($request){
        $token = $request->bearerToken();
        $tokenId = (new Parser(new JoseEncoder()))->parse($token)->claims()->all()['jti'];
        $client = Token::find($tokenId)->client;
        $client_id = $client->user_id;
        return $client_id;
    }

}
