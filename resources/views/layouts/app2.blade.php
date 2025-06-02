<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Elsikomang Klak-Klik')</title>
    @include('components.head')
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <!-- <script src="//unpkg.com/alpinejs" defer></script> -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>



</head>

<body>
    <main>
        <div id="app-layout" class="overflow-x-hidden flex">
            @include('components.sidebar2')
            <div id="app-layout-content"
                class="min-h-screen w-full min-w-[100vw] md:min-w-0 ml-[15.625rem] [transition:margin_0.25s_ease-out]">
                <div class="header">
                    @include('components.navbar')
                </div>

                {{-- Tambahin yield content di sini --}}
                <div>
                    @yield('content')
                </div>
                {{-- End yield --}}

            </div>
        </div>
    </main>
    @stack('styles')
    @stack('scripts')
    @include('components.script')
</body>

</html>
