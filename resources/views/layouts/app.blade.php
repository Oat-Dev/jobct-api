<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JobCT') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="preload" as="style" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="preload" as="style" href="{{ mix('css/toastr.css') }}">
    <link rel="stylesheet" href="{{ mix('css/toastr.css') }}">

    @livewireStyles
    @trixassets

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
</head>

<body class="font-sans antialiased">
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')
        <!-- Page Heading -->
        @if (isset($header))

        <body class="bg-gray-50 dark:bg-gray-800 h-screen antialiased leading-none">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </body>
        @endif
        <div x-data="{ sidebarOpen: false }" class="mx-auto flex h-full min-h-screen bg-gray-200 font-roboto">
            @include('sidebar')
            <!-- Page Content -->
            <div class="container mx-auto px-6 py-5">
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>

    @stack('modals')

    @livewireScripts

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    @if (Session::has('toastr'))
    <script>
        @if (isset(Session::get('toastr')['type']) && Session::get('toastr')['type'] == 'success')
        toastr.success("{!! Session::get('toastr')['message'] !!}", "{!! Session::get('toastr')['title'] !!}");
        @elseif (isset(Session::get('toastr')['type']) && Session::get('toastr')['type'] == 'info')
        toastr.info("{!! Session::get('toastr')['message'] !!}", "{!! Session::get('toastr')['title'] !!}");
        @elseif (isset(Session::get('toastr')['type']) && Session::get('toastr')['type'] == 'warning')
        toastr.warning("{!! Session::get('toastr')['message'] !!}", "{!! Session::get('toastr')['title'] !!}");
        @elseif (isset(Session::get('toastr')['type']) && Session::get('toastr')['type'] == 'error')
        toastr.error("{!! Session::get('toastr')['message'] !!}", "{!! Session::get('toastr')['title'] !!}");
        @endif
    </script>
    @endif
    <script>
        Livewire.on('toastrAdded', toastrData => {
            if (toastrData.type === 'success') {
                toastr.success(toastrData.message, toastrData.title);
            } else if (toastrData.type === 'info') {
                toastr.info(toastrData.message, toastrData.title);
            } else if (toastrData.type === 'warning') {
                toastr.warning(toastrData.message, toastrData.title);
            } else {
                toastr.error(toastrData.message, toastrData.title);
            }
        });
        Livewire.onError(statusCode => {
            if (statusCode === 500 || statusCode === 501 || statusCode === 502 || statusCode === 504) {
                var element = document.getElementById("http-server-error");
                element.classList.remove("hidden");
            }
            return false;
        });
    </script>
</body>

</html>