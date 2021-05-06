<?php


namespace App\Helper;


use Illuminate\Support\Facades\Http;
use Laravel\Passport\Token;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;


class Omnitron
{

    public $productUrl = 'https://akinon-bo.akinon.net/api/v1/products/detailed/';
    public $loginUrl = 'https://akinon-bo.akinon.net/api/v1/auth/login/';
    public $collectionUrl = 'https://akinon-bo.akinon.net/api/v1/product_collections/';
    public $username = 'oms.application';
    public $password = 'V5hhYn6QBrUypmaF';

    public function getProducts()
    {
        $token = $this->login();
        return Http::withHeaders([
            'Authorization' => 'Token ' . $token
        ])->get($this->productUrl, ['limit' => 20])->json();
    }

    public function getCollections()
    {
        $token = $this->login();
        return Http::withHeaders([
            'Authorization' => 'Token ' . $token
        ])->get($this->collectionUrl, ['limit' => 10])->json()['results'];
    }

    public function getProductById($id)
    {
        $token = $this->login();
        return Http::withHeaders([
            'Authorization' => 'Token ' . $token
        ])->get($this->productUrl, ['id' => $id])->json()['results'][0];
    }

    public function login()
    {
        return Http::post($this->loginUrl, ['username' => $this->username, 'password' => $this->password])->json()['key'];
    }

}
