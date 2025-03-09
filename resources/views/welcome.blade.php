<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>X-Bakery</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/favicon.ico') }}" />
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/toastify.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/tailwind.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/swiper-bundle.min.css') }}" rel="stylesheet" />

    {{-- script --}}
    <script src="{{ asset('js/toastify-js.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/config.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
</head>

<body class="">

    <div id="loader" class="LoadingOverlay d-none">
        <div class="Line-Progress">
            <div class="indeterminate"></div>       
        </div>
    </div>
    @include('components.app.header')
    <h1 id="app" class="bg-gray-800 text-8xl text-center mt-20">Hello world</h1>
    <div class="swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">Slide 1</div>
            <div class="swiper-slide">Slide 2</div>
            <div class="swiper-slide">Slide 3</div>
        </div>
        <!-- Optional Navigation Buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
 
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            successToast("hello")
        })
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.swiper', {
            loop: true, // Enables continuous loop mode
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });

    $('#app').click(function() {
    axios.post('http')
    })
</script>

</body>

</html>
