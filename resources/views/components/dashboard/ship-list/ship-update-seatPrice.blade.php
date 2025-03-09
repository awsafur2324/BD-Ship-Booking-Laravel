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
        const seatAndArrivalCollection = [];

        $('#next-ship-seat').click(async function(e) {
            e.preventDefault();
            const len = $(".seat-category-section").length;
    
            if(len == 0){
                errorToast("Please add at least one seat category.");
                return; // Stop execution if there are no seat categories
            }
            // Collect seat data
            const seatData = [];
            $('.seat-map-class').each(function() {
                const seat_category = $(this).find('input[name="seat_category"]').val();
                const seat_row = $(this).find('input[name="seat_row"]').val();
                const seat_column = $(this).find('input[name="seat_column"]').val();
                const seat_tag = $(this).find('input[name="seat_tag"]').val();

                seatData.push({
                    seat_category,
                    seat_row,
                    seat_column,
                    seat_tag,
                });
            });

            // Validate seat data
            function hasDuplicateRoute(array) {
                const seat = new Set();
                for (const item of array) {
                    if (
                        seat.has(item.seat_category)
                    ) {
                        return true; // Duplicate found
                    }
                    seat.add(item.seat_category);
                }
                return false; // No duplicates
            }

            // Check for empty fields
            const hasEmptyFields = seatData.some(route =>
                Object.values(route).some(field => !field)
            );

            if (hasEmptyFields) {
                errorToast("Please fill in all required fields.");
                return; // Stop execution if there are empty fields
            }

            if (hasDuplicateRoute(seatData)) {
                errorToast("Duplicate value found. Please check the Seat Map again.");
                seatData = [];
                return; // Stop execution if there are duplicate values
            }

            // Collect departure and arrival data
            const departure_from = $('#departure_from').val();
            const arrivalData = [];
            $('.add-route-class').each(function() {
                const arrival_at = $(this).find('input[name="arrival_at[]"]').val();
                const arrival_date = $(this).find('input[name="arrival_date[]"]').val();
                const arrival_time = $(this).find('input[name="arrival_time[]"]').val();

                arrivalData.push({
                    arrival_at,
                    arrival_date,
                    arrival_time,
                });
            });

            // Push to collection
            seatAndArrivalCollection.push({
                departure_from,
                arrivalData,
                seatData,
            });

            // Update UI for seat price
            $('#seat-map-container').find('input').prop('disabled', true);
            $('#next-ship-seat').addClass('hidden');
            $('#add-another-seat-btn').addClass('hidden');
            $('.delete-seat-class').addClass('hidden');
            $('#btn_submit').removeClass('hidden');
            $('#seat-price-container').removeClass('hidden');

            // Populate seat prices dynamically
            const $seatPriceContainer = $('#seat-price-container > div');
            $seatPriceContainer.empty();

            seatAndArrivalCollection.forEach(route => {
                route.arrivalData.forEach(arrival => {
                    const routeHeaderHtml = `
                        <div id="seat-map-hr">
                            <p class="text-center w-full text-sm text-[#07074D] font-bold">
                                ${route.departure_from} To ${arrival.arrival_at}
                            </p>
                            <hr class="my-2 border-b-[1px] border-[#e0e0e0] w-1/2 mx-auto" />
                        </div>`;
                    $seatPriceContainer.append(routeHeaderHtml);

                    route.seatData.forEach(seat => {
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
                            </div>`;
                        $seatPriceContainer.append(seatHtml);
                    });
                });
            });

            // Optionally include predefined prices from server
            const predefinedSeatPrices = @json($seat_price);
            predefinedSeatPrices.forEach(priceGroup => {
                const arrivalPoint = priceGroup.arrival_point;
                priceGroup.seat_price.forEach(seatPrice => {
                    const selector = `input[name="seat_price_${departure_from}_${arrivalPoint}_${seatPrice.category}"]`;
                    const $input = $(selector);
                    if ($input.length) {
                        $input.val(seatPrice.seat_price);
                        $input.data('seat_map_id', seatPrice.seat_map_id);
                    }
                });
            });
        });
    });
</script>