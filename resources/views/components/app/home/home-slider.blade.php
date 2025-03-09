<style>
    .swiper-slide {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transition: height 0.3s ease-in-out;
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

    .countdown {
        display: flex;
        gap: 8px;
    }

    .time-unit {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 20px;
        padding: 8px;
        background: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 5px;
        min-width: 60px;
    }

    .time-unit span {
        font-size: 14px;
        font-weight: bold;
        color: #c00c0c;
    }
</style>

<div class="swiper mySwiper1">
    <div class="swiper-wrapper">
        {{-- Loop through discounts --}}
        @foreach ($discounts as $discount)
            <div class="swiper-slide relative bg-[url('{{ $discount->discountImg }}')] py-20">
                <div class="absolute inset-0 bg-black bg-opacity-60"></div>
                <div class="relative w-full h-full flex flex-col justify-center items-center text-center gap-5">
                    <div class="flex flex-col justify-center items-center">
                        <h1 class="text-3xl font-bold text-green-300">{{ $discount->discount_title }}</h1>
                        <div class="w-10 h-[2px] bg-slate-600"></div>
                    </div>
                    <div class="countdown" id="countdown-{{ $loop->index }}">
                        <div class="time-unit" id="days-{{ $loop->index }}"></div>
                        <div class="time-unit" id="hours-{{ $loop->index }}"></div>
                        <div class="time-unit" id="minutes-{{ $loop->index }}"></div>
                        <div class="time-unit" id="seconds-{{ $loop->index }}"></div>
                    </div>
                    <h2 class="text-base font-medium text-white px-5 md:px-16">{{ $discount->discount_description }}</h2>
                    <p class="text-2xl font-bold text-white font-serif">
                        <sup><i class="fas fa-quote-left text-sm text-green-500"></i></sup>
                        {{ $discount->coupon_code }}
                        <sup><i class="fas fa-quote-right text-sm text-green-500"></i></sup>
                    </p>
                </div>
            </div>
        @endforeach
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
            renderBullet: function (index, className) {
                return '<span class="' + className + '"></span>';
            },
        },
    });

    // Adjust slide heights dynamically
    const adjustSlideHeights = () => {
        const slides = document.querySelectorAll('.swiper-slide');
        let maxHeight = 0;

        // Find the maximum height of all slides
        slides.forEach(slide => {
            slide.style.height = 'auto'; // Reset height to calculate the natural height
            const height = slide.offsetHeight;
            if (height > maxHeight) {
                maxHeight = height;
            }
        });

        // Apply the maximum height to all slides
        slides.forEach(slide => {
            slide.style.height = `${maxHeight}px`;
        });
    };

    // Adjust heights on page load and after Swiper initialization
    window.addEventListener('load', adjustSlideHeights);
    swiper1.on('slideChange', adjustSlideHeights);

    // Countdown for each slide
    const discounts = @json($discounts);

    discounts.forEach((discount, index) => {
        const targetDate = new Date(discount.finishDate).getTime();

        const updateCountdown = () => {
            const now = new Date().getTime();
            const timeLeft = targetDate - now;

            if (timeLeft <= 0) {
                clearInterval(interval);
                document.getElementById(`countdown-${index}`).innerHTML = "Countdown Finished!";
                return;
            }

            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            document.getElementById(`days-${index}`).innerHTML = `<span>Days</span>${days}`;
            document.getElementById(`hours-${index}`).innerHTML = `<span>Hours</span>${hours}`;
            document.getElementById(`minutes-${index}`).innerHTML = `<span>Minutes</span>${minutes}`;
            document.getElementById(`seconds-${index}`).innerHTML = `<span>Seconds</span>${seconds}`;
        };

        const interval = setInterval(updateCountdown, 1000);
    });

    // Re-adjust slide heights if the window resizes
    window.addEventListener('resize', adjustSlideHeights);
</script>
