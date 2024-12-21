<div id="seat-map-container" class="hidden">
    <h1 class="text-xl font-bold text-[#07074D] my-5">
        <i class="fas fa-chair"></i>
        Seat Map
    </h1>
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
                    <label for="seat_tag" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Seat Tag Code(e.g. Eco)
                    </label>
                    <input type="text" name="seat_tag" id="seat_tag" placeholder="Enter seat tag code"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
            <div class="w-full px-3 sm:w-1/2">
                <div class="mb-5">
                    <label for="seat_row" class="mb-3 block text-base font-semibold text-[#07074D]">
                        Seats in a row
                    </label>
                    <input type="number" name="seat_row" id="seat_row"
                        placeholder="Enter the number of seats in a row"
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
</div>
{{-- Next button --}}
<div class="w-full p-5 bg-gray-100 flex justify-center items-center text-[#07074D] gap-5">
    <button id="next-ship-seat"
        class=" hidden rounded text-lg px-20 py-3 overflow-hidden group bg-green-500 relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300">
        <span
            class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-52 ease"></span>
        <span class="relative">Next</span>
    </button>
</div>

<script>
    $(document).ready(function() {
        let seatsCount = 1;
        const seatMap = $('#seat-map');
        $('#add-another-seat-btn').on('click', function(e) {
            e.preventDefault();
            seatsCount++;
            $('#seat-map-hr').removeClass('hidden');
            // Clone the original element
            const newSeat = seatMap.clone();
            newSeat.find('input').val(''); // Reset the input values

            // Add a separator
            const addSeat = $(
                `  <div id="seat-map-hr">
                <p class="text-center w-full text-sm text-[#07074D]">Seat Map for Category ${seatsCount}</p>
                <hr class="my-2 border-b-[1px] border-[#e0e0e0] w-1/2 mx-auto" />
            </div>`
            );

            // Append the separator and cloned element to the parent
            seatMap.parent().append(addSeat).append(newSeat);
        })

        // click in next-ship-seat button action in shipSeat-price.blade.php page
        

    });
</script>
