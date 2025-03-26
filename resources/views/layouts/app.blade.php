<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Elsikomang Klak-Klik')</title>
    @include('components.head')
</head>

<body>
    <main>
        <div id="app-layout" class="overflow-x-hidden flex">
            @include('components.sidebar')
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
    @include('components.script')
</body>

</html>
