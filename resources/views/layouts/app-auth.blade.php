<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body class="bg-white">
    <div id="app">
        <div class="container-fluid d-flex p-0" style="min-height: 100vh; max-height: 100vh;">
            <div class="d-flex flex-column flex-shrink-0 p-4 m-4 w-full rounded-3 bg-white shadow" style="width: 280px;">
                <a class="d-flex align-items-center text-black text-decoration-none fs-1"
                    href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <div class="fs-6 mt-3">
                    <a class="fw-bolder fs-5" href="{{ route('lists.index') }}">Мои списки</a>
                    {{-- <ul class="nav flex-column my-2">
                        <li class="nav-item">
                            <a class="nav-link active px-0 py-1 text-black fw-lighter" href="#">- Active</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-0 py-1 text-black fw-lighter" href="#">- List 1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-0 py-1 text-black fw-lighter" href="#">- List 2</a>
                        </li>
                    </ul> --}}
                    <br>
                    <a class="btn btn-outline-secondary btn-sm mt-4" href="{{ route('lists.create') }}">+ | новый список</a>
                </div>

                <hr class="mt-auto">
                <div class="dropdown ">
                    <a href="#" class="d-flex align-items-center text-black text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                        {{-- <img src="" alt="" width="44" height="44" class="rounded-circle me-2"> --}}
                        <strong>{{ Auth::user()->name }}</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser"
                        style="">
                        {{-- <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li> --}}
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Выход
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <main class="w-100 p-4 m-4 ms-0 rounded-3 bg-white shadow overflow-auto"{{--  style="max-height: 100vh;" --}}>
                @yield('content')
            </main>
        </div>
    </div>
</body>

<script type="module">
    $(function() {
        $('.ajax-form').on('submit', (e) => {
            e.preventDefault()
            sendForm(e.target)
        })
    });

    const sendForm = (form) => {
        $('.alert-success').addClass('visually-hidden')

        $.ajax({
            url: $(form).attr('action'),
            type: 'post',
            processData: false,
            contentType: false,
            dataType: 'json',
            data: new FormData(form),
            success: function(data) {
                renderSucces(data.message)
            },
            error: function(data) {
                renderErrors(data.responseJSON)
            }

        });
    }

    const renderSucces = (message) => {
        $('.alert-success')
            .removeClass('visually-hidden')
            .text(message)
    }

    const renderErrors = (errors) => {
        for (const name in errors) {
            $(`#error-${name}`).remove()
            $(`[name='${name}']`)
                .addClass('is-invalid')
                .after(`<label class="invalid-feedback" id="error-${name}">${errors[name]}</label>`)
        }
    }
</script>

</html>
