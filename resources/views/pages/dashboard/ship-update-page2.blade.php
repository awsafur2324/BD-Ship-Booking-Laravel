@extends('layouts.dashboard_layout')
@section('content')
    {{-- Delete offer route form --}}
    <div class="absolute top-2 right-2">
        <button id="delete-route"
            class="inline-flex items-center justify-center w-full px-3 py-2 text-lg text-white bg-red-500 rounded-md hover:bg-red-400 sm:w-auto sm:mb-0"
            data-primary="green-400" data-rounded="rounded-2xl" data-primary-reset="{}">
            Ban This Route<i class="ml-2 fas fa-ban"></i>
        </button>
    </div>

    <h1 class="text-center text-2xl p-5 font-semibold capitalize mt-5 sm:mt-0">
        Ship Update ({{ \Carbon\Carbon::parse($routes[0]['departure_date'])->format('d-m-Y') }})
    </h1>

    @include('components.dashboard.ship-list.ship-update-route', ['routes' => $routes])
    @include('components.dashboard.ship-list.ship-update-seatMap', ['seat_maps' => $seat_maps])
    @include('components.dashboard.ship-list.ship-update-seatPrice', ['seat_price' => $seat_price])
    {{-- submit Button --}}
    <div class="w-full p-5 bg-gray-100 flex justify-center items-center text-[#07074D] gap-5">
        <button id="btn_submit"
            class="rounded hidden text-lg px-20 py-3 overflow-hidden group bg-green-500 relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300">
            <span
                class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-52 ease"></span>
            <span class="relative">Update</span>
        </button>
    </div>

    {{-- model --}}
    <div id="modelConfirm" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 ">
        <div id="closeModel" class="absolute top-5 right-5 px-1.5 cursor-pointer text-red-600 bg-white rounded-full">
            &times;</div>
        <div class="relative top-32 mx-auto shadow-xl rounded-md bg-white max-w-md">
            <h1 class="p-5 text-center text-lg font-semibold text-red-500">If you Ban this route then user will not be able to book this route!</h1>
            <div id="modelBody"
                class="flex flex-wrap p-5 w-full rounded-lg shadow bg-white gap-3  font-semibold text-center justify-center items-center">
                <button id="delete-btn" data-id="{{ $routes[0]['departure_point_id'] }}"
                    class="inline-flex items-center justify-center w-full px-3 py-2 text-lg text-white bg-red-500 rounded-md hover:bg-red-400 sm:w-auto sm:mb-0"
                    data-primary="green-400" data-rounded="rounded-2xl" data-primary-reset="{}">
                    Ban Anyway<i class="ml-2 fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(document).on('click', '#btn_submit', async function(e) {
                e.preventDefault();
                let shipRoute = []; // Array to store updated route data

                // Add departure route data to shipRoute
                shipRoute.push({
                    shipDetail_id: $('#shipDetails_id').val(),
                    departure_point_id: $('#departure_point_id').val(),
                    departure_from: $('#departure_from').val(),
                    departure_date: $('#departure_date').val(),
                    departure_time: $('#departure_time').val(),
                });

                // Collect arrival point data
                let arrivalPoints = [];
                $('.add-route-class').each(function() {
                    const arrival_point_id = $(this).find('input[name="arrival_point_id[]"]')
                        .val() || null;
                    const arrival_at = $(this).find('input[name="arrival_at[]"]').val();
                    const arrival_date = $(this).find('input[name="arrival_date[]"]').val();
                    const arrival_time = $(this).find('input[name="arrival_time[]"]').val();

                    arrivalPoints.push({
                        arrival_point_id,
                        arrival_at,
                        arrival_date,
                        arrival_time,
                    });
                });

                // Add the arrival points data to shipRoute


                //catch seat map data
                const seatData = []; // Array to hold the updated seat data

                // Gather updated seat data from the form inputs
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

                // Catch seat price data
                const seatPrices = []; // Initialize array to store data

                // Loop through each route and collect data
                $('#seat-price-container > div > div').each(function() {
                    const routeElement = $(this);

                    // Collect seat prices for this route
                    routeElement.find('input[name^="seat_price"]').each(function() {
                        const input = $(this);
                        const nameParts = input.attr('name').split(
                            '_'); // Split name by underscore

                        // Extract seat_category (last part of name)
                        const seat_category = nameParts.pop();

                        // Extract arrival_at (third part of name)
                        const arrival_at = nameParts[
                            3]; // The third part should correspond to arrival_at
                        const seat_map_id = input.data(
                            'seat_map_id'
                        ); // The third part should correspond to arrival_at

                        // Get the seat price value and trim any extra spaces
                        const seat_price = input.val().trim();

                        // Add to array
                        seatPrices.push({
                            seat_map_id: seat_map_id,
                            arrival_at: arrival_at,
                            seat_category: seat_category,
                            seat_price: seat_price
                        });
                    });
                });

                // Validate seatPrices data
                let hasEmptyFields = false; // Flag to track empty fields

                seatPrices.forEach(price => {
                    if (!price.seat_price) {
                        hasEmptyFields = true;
                        return false; // Exit loop on first empty field
                    }
                });

                if (hasEmptyFields) {
                    // Show error toast and prevent further actions
                    errorToast("Please fill in all seat price fields.");
                    return; // Stop execution if any field is empty
                }

                const combinedData = [];
                arrivalPoints.forEach((arrivalPoint) => {
                    seatData.forEach((seat) => {
                        seatPrices.forEach((price) => {
                            // Check if seat category and arrival_at match
                            if (seat.seat_category === price.seat_category &&
                                arrivalPoint.arrival_at === price.arrival_at) {
                                combinedData.push({
                                    arrival_point_id: arrivalPoint
                                        .arrival_point_id || null,
                                    arrival_at: arrivalPoint.arrival_at,
                                    arrival_date: arrivalPoint
                                        .arrival_date,
                                    arrival_time: arrivalPoint
                                        .arrival_time,
                                    seat_map_id: price.seat_map_id ||
                                        null,
                                    seat_category: seat.seat_category,
                                    seat_row: seat.seat_row,
                                    seat_column: seat.seat_column,
                                    seat_tag: seat.seat_tag,
                                    seat_price: price.seat_price,
                                });
                            }
                        });
                    });
                });

                const routeData = {
                    shipRoute,
                    arrivalPoints,
                    combinedData,

                };
                console.log(routeData);

                const res = await axios.post('/api/update-departure-based', routeData);

                console.log(res.data);
                if (res.data.success == true) {
                    successToast("Ship route and seat data updated successfully.");
                    setTimeout(() => {
                        window.location.href = '/dashboard/ship-list';
                    }, 1000);

                } else {
                    errorToast("Failed to update ship route and seat data.");
                }

            });
            //close modal
            $('#closeModel').click(function() {
                $('#modelConfirm').addClass('hidden');
            });

            //delete route
            $('#delete-route').click(function() {
                $('#modelConfirm').removeClass('hidden');
            });

            //delete-btn
            $('#delete-btn').click(async function() {
                showLoader();
                let departure_id = $(this).data('id');
                const res = await axios.get(`/api/ban-Departure-route/${departure_id}`);
                hideLoader();
                console.log(res.data);
                // if (res.data.success == true) {
                //     successToast("Ban Route successfully.");
                //     setTimeout(() => {
                //         window.location.href = '/dashboard/ship-list';
                //     }, 1000);
                // } else {
                //     errorToast("Failed to ban route.");
                // }
            });
        })
    </script>
@endsection
