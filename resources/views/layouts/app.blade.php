<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}
    <script src={{asset("public/js/app.js") . "?v=" . filemtime(public_path() . "/js/app.js") }}></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Styles -->
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{asset('public/css/app.css') . "?v=" . filemtime(public_path() . "/css/app.css") }}" rel="stylesheet">
    <link rel="icon" href="{{ URL::to('/') . '/public/ckeditor/uploads/LogoIconGreen.png' }}" type="image/png">

    @stack('styles')
    <style>
        .grecaptcha-badge {
            z-index: 999;
        }
        img {
            max-width: 100%;
        }
        .input-group-prepend > span{
            width: 150px;
        }
        .btn:focus, .btn:active {
            box-shadow: none !important;
        }
        .input-group-prepend > span{
            width: 150px;
        }
        .autocomplete {
            position: relative;
            overflow: visible;
        }
        .autocomplete > input {
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .autocomplete-item {
            position: absolute;

            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;

            max-height: 300px;
            overflow: auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="/public/ckeditor/uploads/LogoTransparentGreen.png" width="150" class="d-inline-block" alt="Laravel" loading="lazy">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto"></ul>

                <form style="width: 100%" autocomplete="off" class="form-inline my-2 my-lg-0">
                    <div style="width: 100%" class="autocomplete">
                        <input style="width: 100%" id="searchBar" class="form-control" placeholder="Search">

                        <div class="autocomplete-list">
                            <div id="search-suggest" class="autocomplete-item search-suggest"></div>
                        </div>
                    </div>
                </form>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('user.page.profile') }}">Profile</a>
                                <a class="dropdown-item" href="{{ route('user.page.profile.posts') }}">My posts</a>
                                @if(Auth::user()->hasRole('admin'))
                                    <a class="dropdown-item" href="{{route('admin.index')}}">Admin panel</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const postList = document.getElementById('search-suggest');
    const searchBar = document.getElementById('searchBar');
    let posts = [];

    searchBar.addEventListener('keyup', (e) => {
        const searchString = e.target.value.toLowerCase();
        if(searchString === '') {
            hidePosts();
            return false;
        }

        const filteredPosts = posts.filter((post) => {
            return (
                post.title.toLowerCase().includes(searchString)
            );
        });
        displayPosts(filteredPosts);
    });

    const loadPosts = async () => {
        try {
            const res = await fetch('{{URL::to('/')}}/api/posts');
            posts = await res.json();
        } catch (err) {
            console.error(err);
        }
    };
    const displayPosts = (posts) => {
        let htmlString = Object.values(posts)
            .map((post) => {
                return `
            <a href="/post/${post.slug}" class="suggest_container list-group-item bg-light list-group-item-action">
                <table>
                    <tr>
                        <td><h4>${post.title}</h4></td>
                    </tr>
                </table>
            </a>
        `;
            })
            .join('');
        postList.innerHTML = htmlString;
    };
    function hidePosts() {
        postList.innerHTML = '';
    }
    loadPosts();
</script>
@stack('scripts')

</body>
</html>
