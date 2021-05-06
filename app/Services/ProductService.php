<?php


namespace App\Services;


use App\Helper\Omnitron;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductService
{

    static function castOmnitronProductToProduct($omnitronModel)
    {
        $product = [
            'name' => $omnitronModel['name'],
            'slug' => Str::slug($omnitronModel['name']),
            'omnitron_id' => $omnitronModel['pk'],
            'price' => 0,
            'image' => $omnitronModel['productimage_set'][0]['image'],
            'brand' => $omnitronModel['brand'] ?? '',
            'attributes' => $omnitronModel['attribute_set']
        ];
        return $product;
    }

    static function createFromOmnitron($data)
    {
        $client = new Omnitron();
        $product = $client->getProductById(3);
        $product = self::castOmnitronProductToProduct($product);
        $product['3d_and'] = $data['3d_and'] ?? '';
        $product['3d_ios'] = $data['3d_ios'] ?? '';
        $product['conf'] = $data['conf'] ?? '';
        $product['video'] = $data['video'] ?? '';
        $product['label'] = $data['label'] ?? '';
        $product['category'] = $data['category'] ?? '';
        $product['event_id'] = $data['event_id'] ?? '';
        return Product::create($product);
    }


    static function sellProduct(Product $product,$eventId)
    {

        $order = Order::create([
            'event_id'=>$eventId,
            'product_id' => $product->id,
            'price' => $product->price
        ]);
        $product->stock = $product->stock-1;
        $product->save();
        return $order;
    }


}
