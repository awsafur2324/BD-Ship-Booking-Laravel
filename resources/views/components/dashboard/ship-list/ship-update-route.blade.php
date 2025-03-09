
{{-- Laravel Blade Template --}}
<div id="route-form-container">
    <div class="">
        <div class="-mx-3 flex flex-wrap relative">
            {{-- Departure Section --}}
            <input id="departure_point_id" class="hidden" type="text"
                value="{{ $routes[0]['departure_point_id'] ?? '' }}">
            <input id="shipDetails_id" class="hidden" type="text" value="{{ $routes[0]['ship_id'] ?? '' }}">
            <div class="w-full px-3">
                <div class="mb-5">
                    <label for="departure_from" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Departure From
                    </label>
                    <input type="text" name="departure_from" id="departure_from"
                        value="{{ $routes[0]['departure_point'] ?? '' }}" placeholder="E.g. Dhaka"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
            <div class="w-full px-3 sm:w-1/2">
                <div class="mb-5">
                    <label for="departure_date" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Departure Date
                    </label>
                    <input type="date" name="departure_date" id="departure_date"
                        value="{{ \Carbon\Carbon::parse($routes[0]['departure_date'])->format('Y-m-d') ?? '' }}"
                        placeholder="E.g. 2022-12-12" disabled
                        class="date-input w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
            <div class="w-full px-3 sm:w-1/2">
                <div class="mb-5">
                    <label for="departure_time" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Departure Time
                    </label>
                    <input type="time" name="departure_time" id="departure_time"
                        value="{{ $routes[0]['departure_time'] ?? '' }}" placeholder="E.g. 12:00 PM"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
        </div>

        {{-- Arrival Points --}}
        @foreach ($routes[0]['arrival_points'] ?? [] as $index => $arrival)
            <div id="add-route-hr">
                <hr class="my-2 border-b-[1px] border-[#e0e0e0] w-1/2 mx-auto" />
                <p class="text-center w-full text-sm text-[#07074D]">
                    {{ $index == 0 ? 'Stop Point 1' : 'Next Stop Point' }}</p>
            </div>
            <div id="add-another-route" class="add-route-class -mx-3 flex flex-wrap relative">
                <input id="arrival_point_id_{{ $index }}" name="arrival_point_id[]" class="hidden" type="text"
                    value="{{ $arrival['arrival_point_id'] ?? '' }}">
                <div class="w-full px-3">
                    <div class="mb-5">
                        <label for="arrival_at_{{ $index }}"
                            class="mb-3 block text-base font-semibold text-[#07074D]">
                            Arrival At
                        </label>
                        <input type="text" name="arrival_at[]" id="arrival_at_{{ $index }}"
                            value="{{ $arrival['arrival_point'] ?? '' }}" placeholder="E.g. Chittagong"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>
                </div>
                <div class="w-full px-3 sm:w-1/2">
                    <div class="mb-5">
                        <label for="arrival_date_{{ $index }}"
                            class="mb-3 block text-base font-semibold text-[#07074D]">
                            Arrival Date
                        </label>
                        <input type="date" name="arrival_date[]" id="arrival_date_{{ $index }}"
                            value="{{ \Carbon\Carbon::parse($arrival['arrival_date'])->format('Y-m-d') ?? '' }}"
                            placeholder="E.g. 2022-12-12"
                            class="date-input w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>
                </div>
                <div class="w-full px-3 sm:w-1/2">
                    <div class="mb-5">
                        <label for="arrival_time_{{ $index }}"
                            class="mb-3 block text-base font-semibold text-[#07074D]">
                            Arrival Time
                        </label>
                        <input type="time" name="arrival_time[]" id="arrival_time_{{ $index }}"
                            value="{{ $arrival['arrival_time'] ?? '' }}" placeholder="E.g. 5:00 PM"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Next button --}}
<div class="w-full p-5 bg-gray-100 flex justify-center items-center text-[#07074D] gap-5">
    <button id="next-ship-route"
        class="rounded text-lg px-20 py-3 overflow-hidden group bg-green-500 relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300">
        <span
            class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-52 ease"></span>
        <span class="relative">Next</span>
    </button>
</div>



<script>
    $(document).ready(function() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Month is zero-indexed
        const day = String(today.getDate()).padStart(2, '0');
        const minDate = `${year}-${month}-${day}`;

        // Set minimum date for all date inputs
        $('.date-input').attr('min', minDate);

        // Add another route functionality
        $('#add-another-arrival-point').on('click', function(e) {
            e.preventDefault();

            // Find the current number of route sections
            const routeIndex = $('.add-route-class').length;

            // Clone the last route section
            const newRoute = $('.add-route-class').last().clone();
            newRoute.find('input').each(function() {
                const oldId = $(this).attr('id');
                const newId = oldId.replace(/\d+$/, '') + routeIndex; // Update id with index
                $(this).attr('id', newId).val(''); // Set new id and clear value
                $(this).prop('disabled', false);
            });

            // Create a separator with the new route number
            const addRouteHr = $(`
            <div id="add-route-hr">
                <hr class="my-2 border-b-[1px] border-[#e0e0e0] w-1/2 mx-auto" />
                <p class="text-center w-full text-sm text-[#07074D]">Next Stop Point</p>
            </div>
        `);

            // Append the separator and the cloned route to the parent container
            $('#route-form-container').append(addRouteHr).append(newRoute);
        });


        // Handle the Next button click
        $('#next-ship-route').on('click', function(e) {
            e.preventDefault();

            // Ship Route Data
            let shipRoute = [];
            shipRoute.push({
                departure_from: $('#departure_from').val(),
                departure_date: $('#departure_date').val(),
                departure_time: $('#departure_time').val(),
            });

            // Iterate through each 'add-route-class' section
            $('.add-route-class').each(function() {
                const arrival_at = $(this).find('input[name="arrival_at[]"]').val();
                const arrival_date = $(this).find('input[name="arrival_date[]"]').val();
                const arrival_time = $(this).find('input[name="arrival_time[]"]').val();

                shipRoute.push({
                    arrival_at,
                    arrival_date,
                    arrival_time,
                });
            });

            function hasDuplicateRoute(array) {
                const arrival = new Set();
                for (const item of array) {
                    if (
                        arrival.has(item.arrival_at) ||
                        arrival.has(item.arrival_time) ||
                        shipRoute[0].departure_from == item.arrival_at ||
                        shipRoute[0].departure_time == item.arrival_time
                    ) {
                        return true; // Duplicate found
                    }
                    arrival.add(item.arrival_at);
                }
                return false; // No duplicates
            }

            // Check for empty fields
            const hasEmptyFields = shipRoute.some(route =>
                Object.values(route).some(field => !field)
            );

            if (hasEmptyFields) {
                errorToast("Please fill in all required fields.");
                return; // Stop execution if there are empty fields
            }

            if (hasDuplicateRoute(shipRoute)) {
                errorToast("Duplicate value found. Please check the arrival points again.");
                shipRoute = [];
                return; // Stop execution if there are duplicate values
            }

            // Show seat map section and disable inputs
            $('#seat-map-container').removeClass('hidden');
            $('#next-ship-seat').removeClass('hidden');
            $('#route-form-container').find('input').prop('disabled', true);
            $('#next-ship-route').addClass('hidden');
            $('#add-another-arrival-point').addClass('hidden');
            $('.delete-route-class').addClass('hidden');
        });
    });
</script>
