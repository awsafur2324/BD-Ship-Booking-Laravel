<div class="w-full ">
    <h1 class="text-4xl font-bold text-center text-[#38c768] mt-10">Assign Ship</h1>
    <div class="mx-auto w-36 border-b-2 border-[#7D7D7D] mb-10 mt-2"></div>

    {{-- form --}}
    <div class="mx-auto w-full ">
        <form id="assign-ship-form">
            {{-- Ship Details Form --}}
            <h1 class="text-2xl font-bold text-[#07074D] my-5">Ship Details</h1>
            @include('components.dashboard.ship-assign.shipDetails-form')
            {{-- Refund Details Form --}}
            <h1 class="text-2xl font-bold text-[#07074D] my-5">Refund Policy</h1>

            @include('components.dashboard.ship-assign.refundPolicy-form')
            {{-- Assign Ship Form --}}
            <div class="">
                <hr class="border-dashed border-[#000000] my-5">
                <div class="my-5">
                    <h1 class="text-2xl font-bold text-[#07074D]">First Day of Assignment</h1>
                    <p class="text-sm text-[#7D7D7D]">The next 10 days will assign automatically based on first day</p>
                </div>
                {{-- Route Map --}}
                <div>
                    <h1 class="text-xl font-bold text-[#07074D] my-5">
                        <i class="fas fa-route"></i>
                        Ship Route
                    </h1>
                    @include('components.dashboard.ship-assign.shipRoute-form')
                </div>
                {{-- Sear Map --}}
                <div>
                    @include('components.dashboard.ship-assign.shipSeat-map')
                </div>
                {{-- Sear Price --}}
                <div>
                    @include('components.dashboard.ship-assign.shipSeat-price')
                </div>
                <hr class="border-dashed border-[#000000] my-5">
            </div>

            <div class="w-full p-5 bg-gray-100 flex justify-center items-center text-[#07074D] gap-5">
                {{-- Submit button --}}
                <button type="submit" id="btn_submit"
                    class="hidden rounded text-lg px-20 py-3 overflow-hidden group bg-green-500 relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300">
                    <span
                        class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-52 ease"></span>
                    <span class="relative">Assign Ship</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $('document').ready(function() {
        //-----------------------------------show set map form 

        async function assignShipData() { // Wrap in an async function
            try {
                const shipDetails = [{
                    ship_name: $('#ship_name').val(),
                    couch_no: $('#couch_no').val(),
                    ship_register_no: $('#ship_register_no').val(),
                    manager_name: $('#manager_name').val(),
                    manager_number: $('#manager_number').val()
                }];
                const refundPolicyData = await getRefundPolicyData();

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

                // ------------------------------------seat map data
                let seatMap = [];
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
                });

                //-------------------------------seat price data
                const seatPrices = []; // Initialize array to store data
                // Loop through each route and collect data
                $('#seat-price-container > div > div').each(function() {
                    const routeElement = $(this);

                    // Collect seat prices for this route
                    routeElement.find('input[name^="seat_price"]').each(function() {
                        const input = $(this);
                        const seat_category = input.attr('name').split('_')
                            .pop(); // Extract seat category from name
                        const nameParts = input.attr('name').split('_');
                        const arrival_at = nameParts[nameParts.length - 2];

                        const seat_price = input.val(); // Get seat price value

                        // Add to array
                        seatPrices.push({
                            arrival_at : arrival_at,
                            seat_category: seat_category,
                            seat_price: seat_price
                        });
                    });
                });


                // Check for empty fields
                const requiredFields = [
                    ...Object.values(shipDetails[0])
                ]
                const requiredPrice = [
                    ...seatPrices.map(price => Object.values(price))
                ].flat();
                const hasEmptyFields = requiredFields.some(field => !field);
                const hasEmptyFieldsInPrice = requiredPrice.some(field => !field);

                if (hasEmptyFields || hasEmptyFieldsInPrice) {
                    errorToast("Please fill in all required fields.");
                    return; // Stop execution if there are empty fields
                }

                // Send data to server
                const data = {
                    shipDetails,
                    refundPolicyData,
                    shipRoute,
                    seatMap,
                    seatPrices,
                };
                // console.log("data:", data);
                showLoader(); //--check config.js file
                let res = await axios.post("/api/assignShip", data);
                hideLoader() //--check config.js file
                // console.log("data:", res);
                if (res.data.status == 'success') {
                    successToast(res.data.message);
                    setTimeout(() => {
                        $('#assign-ship-form').find('input , select').val('');
                        window.location.href = "/dashboard/ship-assign";
                    }, 1000);
                } else {
                    errorToast(res.data.message);
                }


            } catch (error) {
                console.error(error);
                // Handle the error appropriately, e.g., display an error message to the user
            }
        }

        $('#btn_submit').click(function(e) {
            e.preventDefault();
            assignShipData();
        });
    });
</script>
