<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ship Booking | Dashboard</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/favicon.ico') }}" />
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/toastify.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/swiper-bundle.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" />

    {{-- script --}}
    <script src="{{ asset('js/tailwind.min.v3.js') }}"></script>
    <script src="{{ asset('js/toastify-js.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/config.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
</head>

<body>
    {{-- preloader --}}
    <div id="preloader" class="w-full h-screen flex justify-center items-center bg-gray-200">
        @include('components.preloader')
    </div>
    <div id="body-container" class="hidden">
        {{-- loader --}}
        <div id="loader" class="LoadingOverlay d-none">
            <div class="Line-Progress">
                <div class="indeterminate"></div>
            </div>
        </div>

        <div class="">
            {{-- top Nav --}}
            <div class="w-full h-14 bg-gray-200 shadow fixed z-50 top-0">
                @include('components.dashboard.dashboard-topNav')
            </div>
            <div class="flex flex-row justify-end items-start w-full h-screen mt-14 transition-all duration-200 ease-in-out">
                {{-- side Nav --}}
                <div id="side-nav"
                    class="w-full max-w-[250px] shadow-lg h-full overflow-y-auto fixed top-14 -left-[300px] md:left-0 z-40 bg-white transition-all duration-300 ease-in-out">
                    @include('components.dashboard.dashboard-sidenav')
                </div>
                {{-- main content --}}
                <div id="main-content" class="relative  w-full md:max-w-[calc(100%-250px)] overflow-y-auto overflow-x-hidden p-2 transition-all duration-300 ease-in-out">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    {{-- #body-container --}}

    <script>
        //-------Preloader-------
        $(document).ready(function() {
            // Initially, make the body container hidden
            // $('#body-container').addClass('hidden');

            // Set a timeout for preloader to fade out after a specific time (e.g., 20 seconds)
            setTimeout(function() {
                // Fade out preloader and show body container
                $('#preloader').fadeOut('slow', function() {
                    $('#body-container').removeClass('hidden').css('display',
                        'block'); // Show content
                });
            }, 2000);
        });

        //-------Side Nav Action------
        $('#burger').click(function() {
            $('#side-nav').removeClass('-left-[300px]');
            $('#side-nav').addClass('left-0');
            $('#main-content').addClass('max-w-[calc(100%-250px)]');
            $('#burger').toggleClass('hidden');
            $('#cross').toggleClass('hidden');
        })
        $('#cross').click(function() {
            $('#side-nav').removeClass('left-0');
            $('#side-nav').addClass('-left-[300px]');
            $('#main-content').removeClass('max-w-[calc(100%-250px)]');
            $('#burger').toggleClass('hidden');
            $('#cross').toggleClass('hidden');
        })
    </script>
</body>

</html>
