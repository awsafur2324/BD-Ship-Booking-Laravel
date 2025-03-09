<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ship Booking</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/favicon.ico') }}" />
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/toastify.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/swiper-bundle.min.css') }}" rel="stylesheet" />

    {{-- script --}}
    <script src="{{ asset('js/tailwind.min.v3.js') }}"></script>
    <script src="{{ asset('js/toastify-js.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/config.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
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
        {{-- Nav Bar --}}

        @yield('content')

        {{-- footer --}}

    </div>
    {{-- #body-container --}}

    <script>
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
    </script>
</body>

</html>
