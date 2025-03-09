@extends('layouts.app_layout')
@section('content')
    <div class="my-10 container mx-auto overflow-hidden">
        <h1 class="text-4xl font-bold text-center my-10 text-[#333] mt-20">Find your Destination</h1>
        <div class="lg:hidden flex flex-row justify-end items-center p-2 pt-4 bg-white cursor-pointer text-sm">
            <div onclick="toggleFilter()" class="text-[#000000ab]"><i class="fas fa-filter"></i> Apply Filter</div>
        </div>
        <div class="bg-white flex flex-row justify-between items-start px-2 mb-10">
            <div id="filter"
                class="fixed hidden lg:block lg:sticky top-20 w-full lg:w-96 p-2 pb-20 z-10 inset-0 bg-opacity-60 overflow-y-auto h-full">
                @include('components.app.find-destination.filter-component')
            </div>
            <div id="ship-list" class="w-full h-auto p-2 flex flex-col justify-center items-start gap-2">
                <!-- Ships will be dynamically loaded here -->
            </div>
        </div>
    </div>

    {{-- model --}}
    <div id="modelConfirm" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 ">
        <div id="closeModel" class="absolute top-5 right-5 px-1.5 cursor-pointer text-red-600 bg-white rounded-full">
            &times;</div>
        <div class="relative top-32 mx-auto shadow-xl rounded-md bg-white max-w-md">
            <h1 class="p-5 text-center text-lg font-bold ">Where You want to go?</h1>
            <div id="modelBody"
                class="flex flex-col p-5 w-full rounded-lg shadow bg-white gap-3  font-semibold text-center">
                {{-- Dynamic content will be added here --}}
                <div class="w-full flex flex-row justify-start items-center gap-2 text-lg font-semibold">From : <h1>
                        Departure Point</h1>
                </div>
                <div class="w-full flex flex-row justify-start items-center gap-2 text-lg font-semibold">To :
                    <select name="" id=""
                        class=" p-3 rounded-md border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Arrival point</option>
                        <option value="">Arrival point 1</option>
                    </select>
                </div>

                <button id="bookNowBtn" class="bg-blue-500 text-white rounded-md p-2 w-full">Book Now</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            function toggleFilter() {
                document.getElementById('filter').classList.toggle('hidden');
            }

            // Make `onFilterChange` a global function
            window.onFilterChange = function() {
                const filters = {
                    departure_date: document.querySelector('#start_date').value || undefined,
                    departure_from: document.querySelector('#departure_from').value || undefined,
                    ship_name: document.querySelector('#ship_name').value || undefined,
                    available_seats: document.querySelector('#guest_number').value || undefined,
                    arrival_to: document.querySelector('#arrival_to').value || undefined,
                };
                fetchShips(filters);
            };

            function fetchShips(filters = {}) {
                showLoader();
                axios
                    .post('/api/filter', filters)
                    .then(res => {
                        hideLoader();
                        updateShipList(res.data);
                    })
                    .catch(err => {
                        hideLoader();
                        errorToast('Something went wrong. Please try again later.');
                    });
            }

            function updateShipList(ships) {
                const shipListContainer = document.getElementById('ship-list');
                shipListContainer.innerHTML = ''; // Clear previous content

                if (ships.length === 0) {
                    shipListContainer.innerHTML =
                        '<p class="text-center text-red-600 font-bold w-full">No ships found for the selected criteria.</p>';
                    return;
                }

                ships.forEach(ship => {
                    // Format departure date and time
                    const formatDate = (dateString) => {
                        const options = {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        };
                        return new Date(dateString).toLocaleDateString('en-US', options);
                    };

                    const formatTime = (timeString) => {
                        const [hour, minute] = timeString.split(':');
                        const period = hour >= 12 ? 'PM' : 'AM';
                        const formattedHour = ((hour % 12) || 12).toString().padStart(2, '0');
                        return `${formattedHour}:${minute} ${period}`;
                    };
                    const arrivalPointsHTML = ship.arrival_points.map(point => `
                <div class="w-auto h-auto border border-blue-500 rounded-md p-2 text-sm">
                    <h3 class="font-bold text-blue-700">${point.arrival_point}</h3>
                    <div class="w-full flex flex-wrap justify-center items-center gap-2">
                    ${point.seats.map(seat => `
                                <div class=" bg-green-500 text-white rounded-md p-2 mt-2">
                                    <h4>${seat.category} </h4> 
                                    <p>Available Seats: ${seat.available_seats}</p>
                                    <p>Price: ${seat.seat_price} BDT</p></div>`).join('')}
                    </div>
                </div>
            `).join('');

                    const shipHTML = `
                <div onclick='showModel(${JSON.stringify(ship)})' class="group relative w-full shadow-md p-4 flex flex-col md:flex-row justify-between items-start md:items-center border border-gray-200 rounded-md hover:shadow-lg h-auto gap-2 md:gap-5">
                    <div class="text-nowrap flex flex-col justify-start items-start gap-2">
                        <h1 class="group-hover:underline text-2xl font-bold text-center text-[#333]">${ship.ship_name}</h1>
                            <h3 class="font-bold text-[#060e0b]">Coach : <span class="font-medium">${ship.couch_no}</span></h3>   
                    </div>
                
                    <div class="w-full md:w-auto flex flex-wrap md:flex-col justify-between md:justify-start items-center md:items-start my-3 md:my-0 gap-2">
                        <h3 class="font-bold text-[#060e0b]">${ship.departure_point} - ${ship.arrival_points.map(point => point.arrival_point).join(' - ')}</h3>
                        <div class="w-fit flex flex-col justify-start items-start gap-2 font-sans">
                           <h3 class="font-bold text-[#060e0b]">Departure Date: <span class="font-medium text-nowrap">${formatDate(ship.departure_date)}</span></h3>
                            <h3 class="font-bold text-[#060e0b]">Departure Time: <span class="font-medium text-nowrap">${ship.departure_time}</span></h3>
                        </div>
                    </div>
                    <div class="w-full md:w-auto h-auto flex flex-col justify-center items-stretch gap-2 font-semibold">
                        ${arrivalPointsHTML}
                    </div>  
                </div>
            `;

                    shipListContainer.innerHTML += shipHTML;
                });
            }

            // Initial fetch to display ships for the current date
            fetchShips({
                departure_date: new Date().toISOString().split('T')[0]
            });


            //model management
            window.showModel = function(ship) {
                const modelBody = document.getElementById('modelBody');
                modelBody.innerHTML = `
                    <div class="w-full flex flex-row justify-start items-center gap-2 text-lg font-semibold">From: <h1>${ship.departure_point}</h1></div>
                    <div class="w-full flex flex-row justify-start items-center gap-2 text-lg font-semibold">To:
                        <select id="arrivalPointSelect"
                            class="p-3 rounded-md border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            ${ship.arrival_points.map(point => `<option value="${point.arrival_point_id}">${point.arrival_point}</option>`).join('')}
                        </select>
                    </div>
                    <a id="bookNowLink" href="#" class="bg-blue-500 text-white rounded-md p-2 w-full">Book Now</a>
                `;

                const bookNowLink = document.getElementById('bookNowLink');
                const arrivalPointSelect = document.getElementById('arrivalPointSelect');

                // Update the link dynamically based on the selected arrival point
                bookNowLink.addEventListener('click', function() {
                    showLoader();
                    const selectedArrivalPoint = arrivalPointSelect.value;
                    const url =
                        `/booking/${ship.id}/${ship.departure_point_id}/${selectedArrivalPoint}`;
                    this.setAttribute('href', url);
                    hideLoader();
                });

                $('#modelConfirm').removeClass('hidden');
            };

            $(document).on('click', '#closeModel', function() {
                $('#modelConfirm').addClass('hidden');
            });
        });
    </script>
@endsection
