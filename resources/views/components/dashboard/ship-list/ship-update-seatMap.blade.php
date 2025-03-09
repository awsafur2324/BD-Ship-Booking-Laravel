<div id="seat-map-container" class="hidden">
    <h1 class="text-xl font-bold text-[#07074D] my-5">
        <i class="fas fa-chair"></i>
        Seat Map
    </h1>
    <div id="seat-map-all" class="">
        @foreach ($seat_maps as $seat_map)
            <div class="seat-category-section relative">
                <div id="seat-map-hr">
                    <hr class="my-2 border-b-[1px] border-[#e0e0e0] w-1/2 mx-auto" />
                    <p class="text-center w-full text-sm text-[#07074D]"> Seat Map for {{ $seat_map['category'] }}</p>
                </div>
                @foreach ($seat_map['seats'] as $index => $seat)
                    <div id="seat-map" class="seat-map-class -mx-3 flex flex-wrap mt-4">
                        <input id="seat_map_id_{{ $index }}" name="seat_map_id[]" class="hidden" type="text"
                            value="{{ $seat['seat_map_id'] ?? '' }}">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="seat_category" class="mb-3 block text-base font-semibold text-[#07074D]">
                                    Seats Category
                                </label>
                                <input type="text" value="{{ $seat['category'] ?? '' }}" name="seat_category"
                                     id="seat_category" placeholder="Enter your seats type(e.g. Economy Class)"
                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="seat_tag" class="mb-3 block text-base font-semibold text-[#07074D]">
                                    Seat Tag Code(e.g. Eco)
                                </label>
                                <input type="text" name="seat_tag" id="seat_tag"
                                    value="{{ $seat['seat_tag'] ?? '' }}" placeholder="Enter seat tag code" disabled
                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="seat_row" class="mb-3 block text-base font-semibold text-[#07074D]">
                                    Seats in a row
                                </label>
                                <input type="number" name="seat_row" id="seat_row"
                                    value="{{ $seat['seat_in_rows'] ?? '' }}"
                                    placeholder="Enter the number of seats in a row" data-static="true"
                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="seat_column" class="mb-3 block text-base font-semibold text-[#07074D]">
                                    Seats in a column
                                </label>
                                <input type="number" name="seat_column" id="seat_column"
                                    value="{{ $seat['seat_in_columns'] ?? '' }}"
                                    placeholder="Enter the number of seats in a column" data-static="true"
                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#000000] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
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
        $(document).on('blur', 'input[data-static="true"]', function() {
            const currentValue = parseInt($(this).val()) || 0;
            const minValue = parseInt($(this).attr('value')) || 0;

            if (currentValue < minValue) {
                // Set the value to the minimum allowed value
                $(this).val(minValue);
            }
        });
        


    });
</script>
