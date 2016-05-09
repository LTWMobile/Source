@extends('layout.modal')
@section('title', ($_method=='PUT')?$menu->name:'Tạo món mới')
@section('content')

    {!! Form::open([
        'route' => ($_method=='PUT')?[$_route, $shop, $menu]:[$_route, $shop],
        'method' => $_method,
        'class' => 'form-horizontal',
        'files' => true
    ]) !!}

    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="menuName" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        {!! Form::text('name', $menu->name, [
                        'id' => 'menuName',
                        'class' => 'form-control'
                    ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="menuQuantity" class="col-sm-2 control-label">Quantity</label>
                    <div class="col-sm-10">
                        {!! Form::text('quantity', $menu->quantity, [
                        'id' => 'menuQuantity',
                        'class' => 'form-control'
                    ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="menuPrice" class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10">
                        {!! Form::text('price', $menu->price, [
                        'id' => 'menuPrice',
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