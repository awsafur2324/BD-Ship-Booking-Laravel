<div id="seat-price-container" class="hidden">
    <h1 class="text-xl font-bold text-[#07074D] my-5">
        <i class="fas fa-chair"></i>
        Seat Price
    </h1>
    <div>
        <!-- Dynamic content will be injected here by jQuery -->
    </div>
</div>

<script>
    $(document).ready(function() {
        const seatAndArrival_collection = [];
        $('#next-ship-seat').click(async function(e) {
            e.preventDefault();
            // ------------------------------------seat map data
            let seatMap = [];
            let seatData = [];
            // Iterate through each refund-policy section
            $('.seat-map-class').each(function() {
                const seat_category = $(this).find('input[name="seat_category"]').val();
                const seat_row = $(this).find('input[name="seat_row"]').val();
                const seat_column = $(this).find('input[name="seat_column"]').val();
                const seat_tag = $(this).find('input[name="seat_tag"]').val();

                seatMap.push({
                    seat_category,
                    seat_row,
                    seat_column,
                    seat_tag,

                });
                seatData.push({
                    seat_category,
                });
            });

            function hasDuplicateSeat(array) {
                const seats = new Set();
                for (const item of array) {
                    if (seats.has(item.seat_category)) {
                        return true; // Duplicate found
                    }
                    seats.add(item.seat_category);
                }
                return false; // No duplicates
            }

            // Check for empty fields
            const requiredFields = [
                ...seatMap.map(seat => Object.values(seat))
            ].flat();

            const hasEmptyFields = requiredFields.some(field => !field);

            if (hasEmptyFields) {
                errorToast("Please fill in all required fields.");
                return; // Stop execution if there are empty fields
            }

            if (hasDuplicateSeat(seatMap)) {
                errorToast("Duplicate value found. Please check the seat map again.");
                seatMap = [];
                return;
            }

            //take departure point
            const departure_from = $('#departure_from').val();
            // take arrival data
            const arrivalData = [];
            $('.add-route-class').each(function() {
                const arrival_at = $(this).find('input[name="arrival_at"]').val();
                const arrival_date = $(this).find('input[name="arrival_date"]').val();
                const arrival_time = $(this).find('input[name="arrival_time"]').val();

                arrivalData.push({
                    arrival_at,
                });
            })
            // Send data to server

            seatAndArrival_collection.push({
                departure_from,
                arrivalData,
                seatData,
            });



            $('#seat-map-container').find('input').prop('disabled', true);
            $('#next-ship-seat').addClass('hidden');
            $('#add-another-seat-btn').addClass('hidden');
            $('#btn_submit').removeClass('hidden');
            $('#seat-price-container').removeClass('hidden');

            //------------------------ Dynamic seat price doing here

            // Target container
            const $seatPriceContainer = $('#seat-price-container > div');

            // Clear existing content
            $seatPriceContainer.empty();

            //seatAndArrival_collection - get from the shipSeat-map.blade.php

            // Generate HTML dynamically
            seatAndArrival_collection.forEach((route) => {
                route.arrivalData.forEach((arrival) => {
                    // Add route header
                    const routeHeaderHtml = `
                            <p id="seat-map-hr">
                                <p class="text-center w-full text-sm text-[#07074D] font-bold">${route.departure_from} To ${arrival.arrival_at}</p>
                                <hr class="my-2 border-b-[1px] border-[#e0e0e0] w-1/2 mx-auto" />
                            </p>
                        `;
                    $seatPriceContainer.append(routeHeaderHtml);

                    // Add seat price inputs for each category
                    route.seatData.forEach((seat) => {
                        const seatHtml = `
                                <div class="seat-price-class -mx-3 flex flex-wrap">
                                    <div class="w-full px-3">
                                        <div class="mb-5">
                                            <label class="mb-3 block text-base font-semibold text-[#07074D]">
                                                Seats Price for - ${seat.seat_category}
                                            </label>
                                            <input type="number" name="seat_price_${route.departure_from}_${arrival.arrival_at}_${seat.seat_category}"
                                                placeholder="Enter your best price"
                                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                        </div>
                                    </div>
                                </div>
                            `;
                        $seatPriceContainer.append(seatHtml);
                    });
                });

            });
        });
    });
</script>
