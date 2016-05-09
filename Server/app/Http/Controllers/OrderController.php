<?php

namespace App\Http\Controllers;

use App\Events\Order;
use App\Models\Menu;
use App\Models\Shop;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = \App\Models\Order::all();
        return view('page.order.index', [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token = $request->get('token');
        $takecoffee_code = json_decode(\Crypt::decrypt($token));
        $shop_id = $takecoffee_code->id;
        $table = $takecoffee_code->table;

        /** @var Menu[] $orders */
        /** @var \App\Models\Shop $shop */
        /** @var \App\Models\Order $order */
        $shop = Shop::findOrNew($shop_id);
        $orderlist = $request->get('id');
        $counts = $request->get('sl');

        $order = new \App\Models\Order();
        $order->table_id = $table;
        $shop->orders()->save($order);
        for ($i = 0; $i < count($orderlist); $i++) {
            $order->items()->attach($orderlist[$i], ['count'=>$counts[$i]]);
        }

        //event(new Order());
        return response()->json([
            "status" => "OK"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
