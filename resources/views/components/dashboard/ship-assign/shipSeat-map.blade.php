<div class="">
    <div id="seat-map-hr" class="hidden">
        <p class="text-center w-full text-sm text-[#07074D]"> Seat Map for Category 1 </p>
        <hr class="my-2 border-b-[1px] border-[#e0e0e0] w-1/2 mx-auto" />
    </div>
    <div id="seat-map" class="seat-map-class -mx-3 flex flex-wrap ">
        <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
                <label for="seat_category" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Seats Category
                </label>
                <input type="text" name="seat_category" id="seat_category"
                    placeholder="Enter your seats type(e.g. Economy Class)"
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        </div>
        <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
                <label for="seat_amount" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Amount of Seats
                </label>
                <input type="number" name="seat_amount" id="seat_amount" placeholder="Enter your email"
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        </div>
        <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
                <label for="seat_row" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Seats in a row
                </label>
                <input type="number" name="seat_row" id="seat_row" placeholder="Enter the number of seats in a row"
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        </div>
        <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
                <label for="seat_column" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Seats in a column
                </label>
                <input type="number" name="seat_column" id="seat_column"
                    placeholder="Enter the number of seats in a column""
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        </div>
        <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
                <label for="seat_tag" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Seat Tag Code
                </label>
                <input type="number" name="seat_tag" id="seat_tag" placeholder="Enter seat tag code"
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        </div>
        <div class="w-full px-3 sm:w-1/2">
            <div class="mb-5">
                <label for="seat_price" class="mb-3 block text-base font-semibold text-[#07074D]">
                    Set Seat Price
                </label>
                <input type="number" name="seat_price" id="seat_price" placeholder="Enter per seat price"
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        </div>
    </div>
</div>
{{-- Add another Seat button  --}}
<button id="add-another-seat-btn"
    class="relative items-center justify-start inline-block px-8 py-3 overflow-hidden font-medium transition-all bg-blue-600 rounded-md hover:bg-white group">
    <span
        class="absolute inset-0 border-0 group-hover:border-[25px] ease-linear duration-100 transition-all border-white rounded-md"></span>
    <span
        class="relative w-full text-left text-white transition-colors duration-200 ease-in-out group-hover:text-blue-600">
        Add Another Category +</span>
</button>

<button id="map-submit">Submit</button>
<script>
    $(document).ready(function() {
        let seatsCount = 1;
        const seatMap = $('#seat-map');
        $('#add-another-seat-btn').on('click', function() {
            seatsCount++;
            $('#seat-map-hr').removeClass('hidden');
            // Clone the original element
            const newSeat = seatMap.clone();
            newSeat.find('input').val(''); // Reset the input values

            // Add a separator
            const addSeat = $(`
            <div id="seat-map-hr">
                <p class="text-center w-full text-sm text-[#07074D]">Seat Map for Category ${seatsCount}</p>
                <hr class="my-2 border-b-[1px] border-[#e0e0e0] w-1/2 mx-auto" />
            </div>
        `);

            // Append the separator and cloned element to the parent
            seatMap.parent().append(addSeat).append(newSeat);
        })

        $('#map-submit').on('click', function(e) {
            e.preventDefault();
            const formData = [];
            // Iterate through each refund-policy section
            $('.seat-map-class').each(function() {
                const seat_category = $(this).find('input[name="seat_category"]').val();
                const seat_amount = $(this).find('input[name="seat_amount"]').val();
                const seat_row = $(this).find('input[name="seat_row"]').val();
                const seat_column = $(this).find('input[name="seat_column"]').val();
                const seat_tag = $(this).find('input[name="seat_tag"]').val();
                const seat_price = $(this).find('input[name="seat_price"]').val();

                formData.push({
                    seat_category,
                    seat_amount,
                    seat_row,
                    seat_column,
                    seat_tag,
                    seat_price
                });
            });

            function hasDuplicateValue(array) {
                const seats = new Set();
                for (const item of array) {
                    if (seats.has(item.seat_category)) {
                        return true; // Duplicate found
                    }
                    seats.add(item.seat_category);
                }
                return false; // No duplicates
            }
            if (hasDuplicateValue(formData)) {
                errorToast("Please select different refund policies for each ship");
            } else {
                // Log the collected data (or send to the backend)
                console.log(formData);
            }
            // Example AJAX submission
            // $.post('/your-endpoint', { data: formData }, function(response) {
            //     console.log(response);
            // });
        });
    });
</script>
