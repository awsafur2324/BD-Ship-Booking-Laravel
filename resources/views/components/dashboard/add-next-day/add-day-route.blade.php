<div id="route-form-container" class="">
    <div class="">
        <div class="-mx-3 flex flex-wrap ">
            <div class="w-full px-3">
                <div class="mb-5">
                    <label for="departure_from" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Departure From
                    </label>
                    <input type="text" name="departure_from" id="departure_from"
                        onkeyup="fetchSuggestions(this, 'departure')" placeholder="E.g. Dhaka"
                        class="autocomplete w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    <ul id="departure_from_list" class="absolute z-10 mt-1 bg-white shadow-lg rounded-sm w-full hidden">
                    </ul>
                </div>
            </div>
            <div class="w-full px-3 sm:w-1/2">
                <div class="mb-5">
                    <label for="departure_date" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Departure Date
                    </label>
                    <input type="date" name="departure_date" id="departure_date" placeholder="E.g. 2022-12-12"
                        min="" value="{{ $lastDateAvailable }}"
                        class="date-input w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
            <div class="w-full px-3 sm:w-1/2">
                <div class="mb-5">
                    <label for="departure_time" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Departure Time
                    </label>
                    <input type="time" name="departure_time" id="departure_time" placeholder="E.g. 12:00 PM"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
        </div>
        <div class="">
            <div id="add-route-hr" class="hidden">
                <hr class="my-2 border-b-[1px] border-[#e0e0e0] w-1/2 mx-auto" />
                <p class="text-center w-full text-sm text-[#07074D]">Stop Point 1</p>
            </div>
            <div id="add-another-route" class="add-route-class -mx-3 flex flex-wrap">
                <div class="w-full px-3">
                    <div class="mb-5">
                        <label for="arrival_at" class="mb-3 block text-base font-semibold text-[#07074D]">
                            Arrival At
                        </label>
                        <input type="text" name="arrival_at" id="arrival_at"
                            onkeyup="fetchSuggestions(this, 'arrival')" placeholder="E.g. Chittagong"
                            class="autocomplete w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        <ul id="arrival_at_list" class="absolute z-10 mt-1 bg-white shadow-lg rounded-sm w-full hidden">
                        </ul>
                    </div>
                </div>
                <div class="w-full px-3 sm:w-1/2">
                    <div class="mb-5">
                        <label for="arrival_date" class="mb-3 block text-base font-semibold text-[#07074D]">
                            Arrival Date
                        </label>
                        <input type="date" name="arrival_date" id="arrival_date" placeholder="E.g. 2022-12-12"
                            min="" value="{{ $lastDateAvailable }}"
                            class="date-input w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>
                </div>
                <div class="w-full px-3 sm:w-1/2">
                    <div class="mb-5">
                        <label for="arrival_time" class="mb-3 block text-base font-semibold text-[#07074D]">
                            Arrival Time
                        </label>
                        <input type="time" name="arrival_time" id="arrival_time" placeholder="E.g. 5:00 PM"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>
                </div>

            </div>
        </div>
    </div>
    <button id="add-another-arrival-point"
        class="relative items-center justify-start inline-block px-8 py-3 overflow-hidden font-medium transition-all bg-blue-600 rounded-md hover:bg-white group">
        <span
            class="absolute inset-0 border-0 group-hover:border-[25px] ease-linear duration-100 transition-all border-white rounded-md"></span>
        <span
            class="relative w-full text-left text-white transition-colors duration-200 ease-in-out group-hover:text-blue-600">Add
            Another Arrival Point +</span>
    </button>
</div>

<div class="w-full p-5 bg-gray-100 flex justify-center items-center text-[#07074D] gap-5">
    <button id="next-ship-route" data-id="{{ $ship_id }}"
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

        let data = 1; // Counter for the route number
        // Add another route functionality
        const shipArrival = $('#add-another-route'); // Original element to clone
        $('#add-another-arrival-point').on('click', function(e) {
            e.preventDefault();
            data++; // Increment route counter
            $('#add-route-hr').removeClass('hidden');
            // Clone the original element
            const newRefund = shipArrival.clone();
            newRefund.find('input[name="arrival_at"]').val(''); // Reset the input values
            newRefund.find('input[name="arrival_time"]').val(''); // Reset the input values

            // Update the ID of the input field and the associated <ul> list
            const newArrivalInput = newRefund.find('input[name="arrival_at"]');
            const newArrivalList = newRefund.find('ul');

            // Set new IDs for the input field and the list (using the current 'data' as the index)
            newArrivalInput.attr('id', `arrival_at_${data}`);
            newArrivalList.attr('id', `arrival_at_${data}_list`);

            // Add a separator
            const addRouteHr = $(`
            <div id="add-route-hr">
                <hr class="my-2 border-b-[1px] border-[#e0e0e0] w-1/2 mx-auto" />
                <p class="text-center w-full text-sm text-[#07074D]">Stop Point ${data}</p>
            </div>
        `);
            // Append the separator and cloned element to the parent
            shipArrival.parent().append(addRouteHr).append(newRefund);
        });

        // check duplicates values 
        $('#next-ship-route').on('click', async function(e) {
            e.preventDefault();

            //----------- Check the departure date is already exist or not
            const departure_date = $('#departure_date').val();
            let ship_id = $(this).data('id');
            const res = await axios.post('/api/check-duplicate-date', {
                departure_date,
                ship_id
            });

            if (res.data > 0) {
                errorToast('This date already exist for this ship.');
                return;
            }

            // ----------------------------------------Ship Route Data
            let shipRoute = [];
            shipRoute.push({
                departure_from: $('#departure_from').val(),
                departure_date: $('#departure_date').val(),
                departure_time: $('#departure_time').val(),
            });

            // Iterate through each 'add-route-class' section
            $('.add-route-class').each(function() {
                const arrival_at = $(this).find('input[name="arrival_at"]').val();
                const arrival_date = $(this).find('input[name="arrival_date"]').val();
                const arrival_time = $(this).find('input[name="arrival_time"]').val();

                shipRoute.push({
                    arrival_at,
                    arrival_date,
                    arrival_time,
                });
            });

            function hasDuplicateRoute(array) {
                const arrival = new Set();
                for (const item of array) {
                    if (arrival.has(item.arrival_at) || arrival.has(item.arrival_time) || shipRoute[
                            0]
                        .departure_from === item.arrival_at || shipRoute[0].departure_time === item
                        .arrival_time) {
                        return true; // Duplicate found
                    }
                    arrival.add(item.arrival_at);
                }
                return false; // No duplicates
            }

            // Check for empty fields
            const requiredFields = [
                $('#departure_from').val(),
                $('#departure_date').val(),
                $('#departure_time').val(),
                ...shipRoute.map(route => Object.values(route)),
            ];

            const hasEmptyFields = requiredFields.some(field => !field);

            if (hasEmptyFields) {
                errorToast("Please fill in all required fields.");
                return; // Stop execution if there are empty fields
            }

            if (hasDuplicateRoute(shipRoute)) {
                errorToast("Duplicate value found. Please check the arrival points again.");
                shipRoute = [];
                return; // Stop execution if there are duplicate values
            }
            // seat maa section will show
            $('#seat-map-container').removeClass('hidden');
            $('#next-ship-seat').removeClass('hidden');
            //all imput field will disable
            $('#route-form-container').find('input').prop('disabled', true);
            $('#next-ship-route').addClass('hidden');
            $('#add-another-arrival-point').addClass('hidden');
        });
    });

    const suggestion = @json($place_suggestion);

    function fetchSuggestions(input, type) {
        const query = input.value.trim();
        const suggestionList = document.getElementById(`${input.id}_list`);

        if (query.length === 0) {
            suggestionList.classList.add('hidden');
            return;
        }

        if (suggestion.length > 0) {
            suggestionList.innerHTML = suggestion
                .map((item) =>
                    `<li class="px-2 py-1 hover:bg-gray-200 cursor-pointer" onclick="selectSuggestion('${input.id}', '${item}')">${item}</li>`
                )
                .join('');
            suggestionList.classList.remove('hidden');
        } else {
            suggestionList.innerHTML = `<li class="px-2 py-1 text-gray-500">No results found</li>`;
        }
    }

    function selectSuggestion(inputId, value) {
        const input = document.getElementById(inputId);
        const suggestionList = document.getElementById(`${inputId}_list`);
        input.value = value;
        suggestionList.classList.add('hidden');
    }

    // Hide suggestion when clicked outside
    $(document).click(function(e) {
        const suggestionList = $('.autocomplete + ul');
        if (!$(e.target).closest('.autocomplete').length) {
            suggestionList.addClass('hidden');
        }
    });
</script>
