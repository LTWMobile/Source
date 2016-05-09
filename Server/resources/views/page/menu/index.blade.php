@extends('layout.default')
@section('content')
    <div class="shop-detail">
        <div class="page-header clearfix">
            <div class="row">
                <div class="col-md-3">
                    <div class="thumbnail shop-thumbnail">
                        <img src="{{ $shop->thumbnail }}" alt="{{ $shop->name }}'s avatar">
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="clearfix shop-title">
                        <h2 class="pull-left">
                            <span class="text-primary">{{ $shop->name }}</span>
                        </h2>
                        <div class="btn-group pull-right">
                            <a href="{{ route('shop.menu.create', ['shop' => $shop]) }}" class="btn btn-success ajax-modal" role="button" data-target="#editModal">
                                <i class="fa fa-plus"></i> Thêm món
                            </a>
                            <a href="#" class="btn btn-info">
                                <i class="fa fa-shopping-cart"></i> Xem DS hoá đơn
                            </a>
                            <a href="{{ route('shop.qr.form', ['shop' => $shop]) }}" class="btn btn-default ajax-modal" role="button" data-target="#editModal">Tạo QRCode</a>
                        </div>
                    </div>
                    <h4 class="shop-stat">
                        <span class="label label-info"><i class="fa fa-coffee"></i>{{ $shop->menu->count() }} món</span>
                        <span class="label label-success"><i class="fa fa-check"></i>{{ $shop->orders->count() }} lượt ghé thăm</span></h4>
                    <br>
                    <p><i class="fa fa-location-arrow"></i>{{ $shop->address }}</p>
                    <p><i class="fa fa-phone"></i>{{ $shop->phonenumber }}</p>
                    <p><i class="fa fa-tag"></i>{{ $shop->lowest_price }}đ - {{ $shop->highest_price }}đ</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($menu as $item)
                <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="thumbnail">
                        <img src="{{ $item->thumbnail }}" alt="{{ $item->name }}">
                        <div class="caption overlay clearfix" style="bottom: 4px; padding-top: 20px;">
                            <div class="pull-left">
                                <h5 class="text-uppercase">{{ $item->name }}</h5>
                                <p><span class="fa fa-tag"></span> {{ $item->price }} VND</p>
                            </div>

                            {!! Form::open([
                                    'route' => ['shop.menu.destroy', $shop, $item],
                                    'method' => 'DELETE'
                                ]) !!}

                            <p class="pull-right-bottom">
                                <a href="{{ route('shop.menu.edit', ['shop' => $shop, 'menu' => $item]) }}" class="ajax-modal" role="button" data-target="#editModal">Sửa</a>
                                <a href="javascript:void(0)" class="delete-modal">Xoá</a>
                            </p>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop