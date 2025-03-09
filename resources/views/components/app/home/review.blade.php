    <!-- Swiper -->
    <h1 class="w-fit mx-auto text-center text-2xl md:text-4xl font-bold gradient-text pt-10 pb-5">Top Reviews</h1>
    <div class="swiper mySwiper2">
        <div class="swiper-wrapper">
            <div class="swiper-slide">@include('components.app.home.review-card', ['name' => 'John Doe'])</div>
            <div class="swiper-slide">@include('components.app.home.review-card', ['name' => 'Kamal Deo'])</div>
            <div class="swiper-slide">@include('components.app.home.review-card', ['name' => 'Jamal Rahman'])</div>
            <div class="swiper-slide">@include('components.app.home.review-card', ['name' => 'Jonny Khan'])</div>

        </div>

    </div>

    <!-- Initialize Swiper -->
    <script>
        var swiper2 = new Swiper(".mySwiper2", {
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            }
        });
    </script>
