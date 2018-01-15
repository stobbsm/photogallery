<div class="container-fluid sticky-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">{{ env('APP_NAME') }} <span class="badge badge-secondary">Beta</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#responsiveHidden" aria-controls="responsiveHidden" aria-expanded="false" aria-label="Toggle Navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="responsiveHidden">
            
            <ul class="navbar-nav mr-0 ml-auto">
                @if (!Auth::check())
                    @include('components.nav_item', ['url' => url('/login'), 'name' => 'Login'])
                    @include('components.nav_item', ['url' => url('/register'), 'name' => 'Register'])
                @else
                    @section('navbar')
                
                    @show
                    @include('components.nav_item', ['url' => action('ImageController@index'), 'name' => 'Gallery'])
                    @include('components.nav_item', ['url' => action('TagController@index'), 'name' => 'Browse'])
                    @include('components.nav_item', ['url' => action('ImageController@create'), 'name' => 'Upload Image'])
                    @include('components.nav_item', ['url' => action('ImageController@notitle'), 'name' => 'Title Files'])
                    @include('components.nav_item', ['url' => action('ImageController@notags'), 'name' => 'Tag Files'])
                    @include('components.nav_item', ['url' => url('/logout'), 'name' => 'Logout'])
                @endif
            </ul>
            
        </div>
    </nav>
</div>