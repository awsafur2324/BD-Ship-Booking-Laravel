@extends('layouts.app_layout')
@section('content')
    <div class="my-10">
        <h1 class="text-4xl font-bold text-center my-10 text-[#333] mt-20 pt-10">Find your Destination</h1>
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

    <script>
        function toggleFilter() {
            document.getElementById('filter').classList.toggle('hidden');
        }

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
                    console.error('Error fetching ships:', err);
                });
        }

        function updateShipList(ships) {
            const shipListContainer = document.getElementById('ship-list');
            shipListContainer.innerHTML = ''; // Clear previous content

            if (ships.length === 0) {
                shipListContainer.innerHTML =
                    '<p class="text-center text-gray-500">No ships found for the selected criteria.</p>';
                return;
            }

            ships.forEach(ship => {
                const arrivalPointsHTML = ship.arrival_points.map(point => `
                <div class="w-auto h-auto border border-blue-500 rounded-md p-2 text-sm">
                    <h3 class="font-bold text-blue-700">${point.arrival_point}</h3>
                    <div class="w-full flex flex-wrap justify-center items-center gap-2">
                    ${point.seats.map(seat => `
                                        <div class=" bg-green-500 text-white rounded-md p-2 mt-2">
                                            <h4>${seat.category} </h4>
                                            <p>Available Seats: ${seat.available_seats}</p>
                                            <p>Price: ${seat.seat_price} BDT</p>
                                        </div>
                                    `).join('')}
                    </div>
                </div>
            `).join('');

                const shipHTML = `
                <a href="#" class="group relative w-full shadow-md p-4 flex flex-col md:flex-row justify-between items-start md:items-center border border-gray-200 rounded-md hover:shadow-lg h-auto">
                    <div class="text-nowrap flex flex-col justify-start items-start gap-2">
                        <h1 class="group-hover:underline text-2xl font-bold text-center text-[#333]">${ship.ship_name}</h1>
                            <h3 class="font-bold text-[#060e0b]">Coach : <span class="font-medium">${ship.couch_no}</span></h3>
                        
                    </div>
                   
                        <div class=" flex flex-wrap md:flex-col justify-between md:justify-start items-stretch md:items-start my-3 md:my-0 gap-2">
                            <h3 class="font-bold text-[#060e0b]">${ship.departure_point} - ${ship.arrival_points.map(point => point.arrival_point).join(' - ')}</h3>
                            <div class="w-fit flex flex-col justify-start items-start gap-2 font-sans">
                                <h3 class="font-bold text-[#060e0b]">Departure Date: <span class="font-medium">${ship.departure_date}</span></h3>
                                <h3 class="font-bold text-[#060e0b]">Departure Time: <span class="font-medium">${ship.departure_time}</span></h3>
                            </div>
                        </div>
                        <div class="w-full md:w-auto h-auto flex flex-col justify-center items-stretch gap-2 font-semibold">
                            ${arrivalPointsHTML}
                        </div>
                    
                </a>
            `;

                shipListContainer.innerHTML += shipHTML;
            });
        }

        // Initial fetch to display ships for the current date
        fetchShips({
            departure_date: new Date().toISOString().split('T')[0]
        });

        // Example of triggering fetch on filter changes
        function onFilterChange() {
            const filters = {
                departure_date: document.querySelector('#start_date').value || undefined,
                departure_from: document.querySelector('#departure_from').value || undefined,
                ship_name: document.querySelector('#ship_name').value || undefined,
                available_seats: document.querySelector('#guest_number').value || undefined,
                arrival_to: document.querySelector('#arrival_to').value || undefined,
            };
            fetchShips(filters);
        }
    </script>
@endsection
