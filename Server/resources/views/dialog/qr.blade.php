@extends('layout.modal')
@section('title','Generate QR code for '.$shop->name)
@section('content')
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="tableId">Enter table ID</label>
                    <input type="text" id="tableId" class="form-control">
                </div>
                <input type="hidden" id="shopId" value="{{ $shop->id }}">
                <div class="form-group">
                    <div class="btn btn-success" id="generate">Generate QR Code</div>
                </div>
            </div>
            <div class="col-sm-6">
                <img class="text-center" src="" alt="" id="qrcode-show" height="250px" width="250px" style="display: block; margin: 0 auto;">
            </div>
        </div>
    </div>
    <script>
        (function($){
            $('#generate').click(function() {
                var shopId = $('#shopId').val();
                var tableId = $('#tableId').val();
                if (tableId == null) {
                    alert('Table ID is not null!');
                } else {
                    $('#qrcode-show').attr('src', 'https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=id%3D' + shopId + '%26table%3D' + tableId + '&choe=UTF-8');
                }
            });
        })(jQuery);
    </script>
@stop