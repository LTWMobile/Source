<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('') }}">
                <img src="{{ url('images/logo.png') }}" alt="TakeCoffee logo" height="50" style="margin: -7.5px;">
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li {!! substr(Route::currentRouteName(), 0, 4)=='shop'?'class="active"':'' !!}><a href="{{ route('shop.index') }}">Shops</a></li>
                <li {!! substr(Route::currentRouteName(), 0, 5)=='order'?'class="active"':'' !!}><a href="{{ route('order.index') }}">Orders</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>