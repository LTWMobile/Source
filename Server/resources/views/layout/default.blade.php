<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
</head>
<body>
    @include('layout.header')
    <div class="container" role="main">
        @yield('content')
    </div>
    @include('layout.footer')
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.3.7.js"></script>
    <script>
        (function($){
            $('a.ajax-modal').click(function(e){
                e.preventDefault();
                var url=$(this).attr('href');
                var modal=$(this).attr('data-target');

                $.ajax({
                    type:'GET',
                    url:url,
                    success:function(data){
                        $(modal).find('.modal-content').html(data);
                        $(modal).modal('show');
                    },
                    error:function(){
                        alert('failure');
                    }
                });
            });
            $('#errorModal, #successModal').modal({
                backdrop: false,
                keyboard: true
            });
            $('a.delete-modal').click(function(e){
                var form = $(this).closest('form').get();
                var conf = confirm("Bạn có chắc chắn muốn xoá không?");
                if (conf){
                    $(form).submit();
                }
            })
        })(jQuery);
    </script>
</body>
</html>