<?php

namespace App\Http\Controllers;

use App\Events\EventClose;
use App\Events\EventStart;
use App\Events\OrderCreate;
use App\Events\ProductDiscount;
use App\Events\ProductHighlight;
use App\Events\StockIncrease;
use App\Events\VisitorAdded;
use App\Helper\Api;
use App\Helper\Utils;
use App\Helper\Validation;
use App\Models\Event;
use App\Models\EventRef;
use App\Models\Product;
use App\Services\EventService;
use App\Services\ProductService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Event::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reflinkCreate(Request $request)
    {

        Validation::validateRequest($request, ['name' => 'required']);
        $data = $request->all();
        $data['code'] = Utils::generateRandomString(6);
        $ref = EventService::createRefLink($data);
        return Api::successResponse($ref);

    }


    public function reflinkList(Request $request)
    {

        $list = EventRef::all();
        return Api::successResponse($list);

    }


    public function providerStatus(Request $request)
    {
        $request = Http::post('https://api.uptimerobot.com/v2/getMonitors', [
            'api_key' => 'u1293455-2ed25ab3b60a3b5ea40a8019',
            'format' => 'json',
            'logs' => 1
        ]);
        $status = EventService::serializeProviderStatus($request->json());
        return Api::successResponse($status);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['name']);
        $event = EventService::create($data);
        if ($request->products) {
            foreach ($request->products as $product) {
                $product['event_id'] = $event->id;
                ProductService::createFromOmnitron($product);
            }
        }
        return Api::successResponse($event);
    }

    public function highlightProduct(Request $request, Product $product)
    {

        broadcast(new ProductHighlight($product))->toOthers();
        return Api::successResponse($product);
    }

    public function discountProduct(Request $request, Product $product)
    {
        $product->price = $request->price;
        $product->save();
        broadcast(new ProductDiscount($product))->toOthers();
        return Api::successResponse($product);
    }

    public function close(Request $request, Event $event)
    {
        broadcast(new EventClose($event))->toOthers();
        return Api::successResponse($event);
    }

    public function start(Request $request, Event $event)
    {
        broadcast(new EventStart($event))->toOthers();
        return Api::successResponse($event);
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return Api::successResponse($event);
    }

    public function showBySlug(Request $request, string $slug)
    {
        $event2 = EventService::getBySlug($slug);
        $event = $event2;
        $ref = $request->input('ref');
        $event = EventService::increaseParticipantWithRef($event->id, $ref);
        broadcast(new VisitorAdded($event->participation));
        return $event2;
    }

    public function report()
    {
        $query = Event::query();
        $monthly = $query->whereMonth('start_date', Carbon::now()->month);
        $data = [
            'monthly_event' => $monthly->count(),
            'monthly_participation' => $monthly->sum('participation'),
            'monthly_product' => $monthly->sum('participation'),
        ];
        return Api::successResponse($data);
    }

    public function past()
    {
        $monthly = Event::whereDate('start_date', '<', date('Y-m-d'))->get();
        return Api::successResponse($monthly);
    }

    public function orderCreate(Request $request)
    {

        $event = Event::find($request->event_id);
        $product = Product::find($request->product_id);
        ProductService::sellProduct($product,$request->event_id);
        broadcast(new OrderCreate($event->orders->count()));
        broadcast(new StockIncrease($product->stock,$product->orders->count()));
        return Api::successResponse($product);
    }

    public function upcoming()
    {
        $monthly = Event::whereDate('start_date', '>', date('Y-m-d'))->get();
        return Api::successResponse($monthly);
    }

    public function getProducts(Event $event)
    {

        return Api::successResponse($event->products);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
//        $event->name = $request->name;
//        $if = $event->save();
//        if($if){
//            return 'ok';
//        }
//        return 'yok';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
