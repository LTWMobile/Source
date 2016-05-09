@extends('layout.default')
@section('content')
    <div class="page-header">
        <h1 class="pull-left">Shop</h1>
        <a href="{{ route('shop.create') }}" class="btn btn-success pull-right ajax-modal" style="margin-top: 26px;" role="button" data-target="#editModal">
            <span class="glyphicon glyphicon-plus"></span>
            &nbsp;&nbsp;Add new shop
        </a>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        @foreach($shops as $shop)
            <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="thumbnail">
                    <img src="{{ $shop->thumbnail }}" alt="{{ $shop->name }}">
                    <div class="caption overlay" style="bottom: 56px;">
                        <h4>
                            <a href="{{ route('shop.menu.index', ['id' => $shop->id]) }}">{{ $shop->name }}</a>
                        </h4>
                        <hr>
                        <p class="small">
                            {{ $shop->address }}
                            <br />
                            Tel: {{ $shop->phonenumber }}
                        </p>
                    </div>
                    <div class="caption">
                        <div class="btn-group" role="group">
                            <a href="{{ route('shop.edit', ['shop' => $shop]) }}" class="btn btn-primary ajax-modal" role="button" data-target="#editModal">Edit</a>
                            <a href="{{ route('shop.qr.form', ['shop' => $shop]) }}" class="btn btn-default ajax-modal" role="button" data-target="#editModal">Gen QR</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop