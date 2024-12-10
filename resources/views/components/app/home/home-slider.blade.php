<style>
    .height-set {
        height: 100%;
        max-height: 350px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .height-set img {
        width: 100%;
        height: auto;
        object-fit: contain;
    }

    .swiper-pagination-bullet {
        display: inline-block;
        width: 5px;
        height: 5px;
        margin: 0 5px;
        background-color: #186ab7;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .swiper-pagination-bullet-active {
        background-color: #186ab7;
        height: 5px;
        width: 15px;
        border-radius: 20%;
        transition: all 0.3s ease-in-out;
    }
</style>
<div class="swiper mySwiper1">
    <div class="swiper-wrapper">
        <div class="swiper-slide height-set">
            <img src="{{ asset('img/discount/1.jpg') }}" alt="">
        </div>
        <div class="swiper-slide height-set">
            <img src="{{ asset('img/discount/2.jpg') }}" alt="">
        </div>
        <div class="swiper-slide height-set">
            <img src="{{ asset('img/discount/3.jpg') }}" alt="">
        </div>

    </div>
    <div class="swiper-pagination"></div>
</div>
<script>
    // Initialize Swiper
    const swiper1 = new Swiper('.mySwiper1', {
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            renderBullet: function(index, className) {
                return '<span class="' + className + '"> </span>';
            },
        },

    });
</script>
