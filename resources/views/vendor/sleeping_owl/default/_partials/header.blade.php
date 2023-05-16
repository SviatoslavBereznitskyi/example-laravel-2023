
<ul class="nav navbar-nav ">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu"><i class="fas fa-bars"></i></a>
    </li>

    @if (config('sleeping_owl.state_datatables') || config('sleeping_owl.state_tabs') || config('sleeping_owl.state_filters'))
        <li class="nav-item">
            <a class="nav-link" href="javascript:localStorage.clear()" data-toggle="tooltip" title="{{ trans('sleeping_owl::lang.button.clear') }} LocalStorage">
                <i class="fas fa-eraser"></i>
            </a>
        </li>
    @endif

    @stack('navbar.left')

    @stack('navbar')
</ul>

<ul class="navbar-nav ml-auto">
    <div class="navbar-custom-menu">

        <ul class="nav navbar-nav">
            @if (Route::has('login'))
                @auth
                    <form method="post" action="{{route('logout')}}">
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-danger" style="color: white">{{__('auth.logout')}}</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="user">w</a>
                @endauth
            @endif
        </ul>

        <ul class="nav navbar-nav navbar-right">

        </ul>
    </div>
    @stack('navbar.right')
</ul>
