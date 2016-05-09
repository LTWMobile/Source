@extends('layout.default')
@section('content')
    <div class="page-header">
        <h1>Orders</h1>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <table id="orderList" class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Shop name</th>
                    <th>Table ID</th>
                    <th>Order at</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr class="success">
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->shop->name }}</td>
                        <td>{{ $order->table_id }}</td>
                        <td>{{ $order->created_at->toDateTimeString() }}</td>
                    </tr>
                    <tr>
                        <td colspan="100%" style="padding-left: 120px;">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Unit Price</th>
                                    <th>Count</th>
                                    <th>Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->price }} VND</td>
                                            <td>{{ $item->pivot->count }}</td>
                                            <td>{{ $item->price * $item->pivot->count }} VND</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                <tr class="text-success">
                                    <td colspan="3"><strong>Totally price</strong></td>
                                    <td><strong>{{ $order->totally }} VND</strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop