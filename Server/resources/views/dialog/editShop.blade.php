@extends('layout.modal')
@section('title', ($_method=='PUT')?$shop->name:'Tạo shop mới')
@section('content')

    {!! Form::open([
        'route' => ($_method=='PUT')?[$_route, $shop]:[$_route],
        'method' => $_method,
        'class' => 'form-horizontal',
        'files' => true
    ]) !!}

    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="shopName" class="col-sm-2 control-label">Shop name</label>
                    <div class="col-sm-10">
                        {!! Form::text('name', $shop->name, [
                        'id' => 'shopName',
                        'class' => 'form-control'
                    ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="shopAddress" class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-10">
                        {!! Form::text('address', $shop->address, [
                        'id' => 'shopAddress',
                        'class' => 'form-control'
                    ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="shopPhone" class="col-sm-2 control-label">Phonenumber</label>
                    <div class="col-sm-10">
                        {!! Form::text('phonenumber', $shop->phonenumber, [
                        'id' => 'shopPhone',
                        'class' => 'form-control'
                    ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Image</label>
                    <div class="col-sm-10">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                            <div>
                                <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>

                                    {!! Form::file('image') !!}

                                </span>
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>

    {!! Form::close() !!}

@stop