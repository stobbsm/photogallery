<div class="container-fluid sticky-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">{{ env('APP_NAME') }} <span class="badge badge-secondary">Beta</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#responsiveHidden" aria-controls="responsiveHidden" aria-expanded="false" aria-label="Toggle Navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="responsiveHidden">
            
            <ul class="navbar-nav mr-auto">
                @if (!Auth::check())
                    @include('components.nav_item', ['url' => url('/login'), 'name' => 'Login'])
                    @include('components.nav_item', ['url' => url('/register'), 'name' => 'Register'])
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarAdminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admin
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarAdminDropdown">
                            @include('components.nav_item', ['url' => action('UserController@index'), 'name' => 'Users'])
                            @include('components.nav_item', ['url' => action('UserController@create'), 'name' => 'Add User'])
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarImageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Gallery
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarImageDropdown">
                            @include('components.nav_item', ['url' => action('ImageController@index'), 'name' => 'View'])
                            @include('components.nav_item', ['url' => action('ImageController@create'), 'name' => 'Upload'])
                            @include('components.nav_item', ['url' => action('ImageController@notitle'), 'name' => 'Title Files'])
                            @include('components.nav_item', ['url' => action('ImageController@notags'), 'name' => 'Tag Files'])
                            @include('components.nav_item', ['url' => action('TagController@index'), 'name' => 'View Tags'])
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarUserMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->email }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarUserMenu">
                            @include('components.nav_item', ['url' => url('/logout'), 'name' => 'Logout'])
                        </ul>
                    </li>
                @endif
            </ul>
            
        </div>
    </nav>
</div>