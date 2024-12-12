<div class="">
    <div class="-mx-3 flex flex-wrap ">
        <div class="w-full px-3">
            <div class="mb-5">
                <label for="departure_from" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Departure From
                </label>
                <input type="text" name="departure_from" id="departure_from" placeholder="E.g. Dhaka"
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        </div>
        <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
                <label for="departure_date" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Departure Date
                </label>
                <input type="date" name="departure_date" id="departure_date" placeholder="E.g. 2022-12-12"
                    min=""
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
                    <input type="text" name="arrival_at" id="arrival_at" placeholder="E.g. Chittagong"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
            <div class="w-full px-3 sm:w-1/2">
                <div class="mb-5">
                    <label for="arrival_date" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Arrival Date
                    </label>
                    <input type="date" name="arrival_date" id="arrival_date" placeholder="E.g. 2022-12-12"
                        min=""
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
{{-- Add another route button  --}}
<button id="add-another-arrival-point"
    class="relative items-center justify-start inline-block px-8 py-3 overflow-hidden font-medium transition-all bg-blue-600 rounded-md hover:bg-white group">
    <span
        class="absolute inset-0 border-0 group-hover:border-[25px] ease-linear duration-100 transition-all border-white rounded-md"></span>
    <span
        class="relative w-full text-left text-white transition-colors duration-200 ease-in-out group-hover:text-blue-600">Add
        Another Arrival Point +</span>
</button>


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

    });
</script>
