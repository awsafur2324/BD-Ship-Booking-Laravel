<h1 class="w-fit mx-auto text-center text-2xl md:text-4xl font-bold gradient-text pt-10 pb-5">The top booking platform in bangladesh</h1>
<div id="counter-section" class="w-full my-5 flex flex-wrap justify-center items-center gap-5 ">
    <!-- Ships -->
    <div
        class="flex flex-col items-center justify-center rounded-md border border-dashed border-gray-200 transition-colors duration-100 ease-in-out hover:border-gray-400/80 p-5 py-8 w-full max-w-96">
        <div class="flex flex-row items-center justify-center text-xl gap-4">
            <i class="fas fa-ship opacity-45"></i>
            <span class="font-bold text-gray-600" id="ship">0</span>
        </div>
        <div class="mt-2 text-base text-gray-400">Available Ships</div>
    </div>

    <!-- Tickets -->
    <div
        class="flex flex-col items-center justify-center rounded-md border border-dashed border-gray-200 transition-colors duration-100 ease-in-out hover:border-gray-400/80 p-5 py-8 w-full max-w-96">
        <div class="flex flex-row items-center justify-center text-xl gap-4">
            <i class="fas fa-ticket-alt opacity-45"></i>
            <span class="font-bold text-gray-600" id="ticket">0</span>
        </div>
        <div class="mt-2 text-base text-gray-400">Tickets Sold</div>
    </div>

    <!-- Customers -->
    <div
        class="flex flex-col items-center justify-center rounded-md border border-dashed border-gray-200 transition-colors duration-100 ease-in-out hover:border-gray-400/80 p-5 py-8 w-full max-w-96">
        <div class="flex flex-row items-center justify-center text-xl gap-4">
            <i class="fas fa-handshake opacity-45"></i>
            <span class="font-bold text-gray-600" id="customer">0</span>
        </div>
        <div class="mt-2 text-base text-gray-400">Happy Customers</div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', () => {
        const counters = [{
                id: 'ship',
                endValue: 500
            },
            {
                id: 'ticket',
                endValue: 10500
            },
            {
                id: 'customer',
                endValue: 20300
            },
        ];

        const duration = 4000; // Total animation duration in milliseconds

        const animateCounter = (id, endValue, duration) => {
            const element = document.getElementById(id);
            const startValue = 0;
            const stepTime = duration / endValue; // Calculate time per increment

            let currentValue = startValue;
            const startTime = performance.now(); // Start time of animation

            const step = (currentTime) => {
                const elapsedTime = currentTime - startTime;
                const progress = Math.min(elapsedTime / duration, 1); // Ensure progress is capped at 1
                currentValue = Math.floor(progress * endValue);
                element.textContent = currentValue.toLocaleString();

                if (progress < 1) {
                    requestAnimationFrame(step);
                }
            };

            requestAnimationFrame(step);
        };

        let hasAnimated = false;

        // Use IntersectionObserver to trigger animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting && !hasAnimated) {
                    hasAnimated = true;
                    counters.forEach(({
                            id,
                            endValue
                        }) =>
                        animateCounter(id, endValue, duration)
                    );
                }
            });
        });

        observer.observe(document.getElementById('counter-section'));
    });
</script>
