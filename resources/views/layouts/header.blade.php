<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-light">
    <a class="navbar-brand" href="{{ route('dashboard') }}"><img src="public/images/logo_header.png" height="35px"></a>
    <a class="btn color-sc1-inv">Admin Control</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>        
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                @if(Auth::guard('web')->check())
                    {{ auth()->guard('web')->user()->name }}
                @elseif(Auth::guard('admin')->check())
                    {{ auth()->guard('admin')->user()->name }} 
                @endif    
            </li>  
       </ul>
    </div>    
</nav>