<style>
    .swiper {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        max-height: 300px;
        text-align: center;
        font-size: 18px;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
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

<div class="swiper mySwiper">
    <div class="swiper-wrapper">
        <div class="swiper-slide">Slide 1</div>
        <div class="swiper-slide">Slide 2</div>
        <div class="swiper-slide">Slide 3</div>
    </div>
    <div class="swiper-pagination"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
    // Initialize Swiper
    const swiper = new Swiper('.mySwiper', {
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
          renderBullet: function (index, className) {
            return '<span class="' + className + '"> </span>';
          },
        },

    });

 
</script>
