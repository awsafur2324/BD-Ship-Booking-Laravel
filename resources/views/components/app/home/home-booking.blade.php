<div class="w-full bg-white px-2 py-8 ">

    <h1 class="w-fit mx-auto text-center text-2xl md:text-4xl font-bold gradient-text my-5">Let's Book A Seat !</h1>

    <div class="w-full flex flex-col lg:flex-row items-start justify-center gap-10 my-5">
        {{-- booking form --}}
        <div class="w-full lg:w-[60%] flex items-center justify-center">
            <div class="mx-auto w-full">
                <div>
                    <div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="departure" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Departure From
                                </label>
                                <input type="text" name="departure" id="departure" placeholder="eg. Dhaka"
                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="arrival" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Arrival To
                                </label>
                                <input type="text" name="arrival" id="arrival" placeholder="eg. Barisal"
                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="guest" class="mb-3 block text-base font-medium text-[#07074D]">
                            How many guest are you bringing?
                        </label>
                        <input type="number" name="guest" id="guest_no" placeholder="5" min="0"
                            class="w-full appearance-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>

                    <div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="date" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Date
                                </label>
                                <input type="date" name="date" id="date"
                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>

                    </div>
                    <div>
                        <button type="submit" onclick="search()"
                            class=" rounded px-5 py-2.5 overflow-hidden group bg-green-500 relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300">
                            <span
                                class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                            <span class="relative">Search</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="available-bookings" class="w-full lg:w-[40%] delay-150 ease-in-out p-0 lg:pr-2 hidden">
            <h2 class="text-left text-2xl font-bold text-[#07074D]">Available Bookings</h2>
            <div id="booking-items">
                <!-- Dynamic items will be added here -->
            </div>
        </div>
        {{-- available bookings --}}

    </div>

    <script>
        async function search() {
            const departure = $('#departure').val();
            const arrival = $('#arrival').val();
            const guest_no = $('#guest_no').val();
            const date = $('#date').val();
            if (!departure || !arrival || !guest_no || !date) {
                errorToast('All fields are required.');
                return;
            }
            const data = {
                departure,
                arrival,
                guest_no,
                date
            };

            try {
                let res = await axios.post('/api/miniSearch', data);

                if (res.data.length > 0) {
                    const bookings = res.data;
                    const bookingItemsContainer = document.getElementById('booking-items');
                    bookingItemsContainer.innerHTML = ''; // Clear previous items

                    bookings.forEach((booking) => {
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
                        const seatsHTML = booking.seats.map(seat => `
                    <div class="p-2">
                        <p class="font-bold">${seat.category}</p>
                        <p class="text-xs font-bold">(${seat.available_seats})</p>
                        <p class="flex flex-row justify-center items-center">${seat.seat_price}<sub>tk</sub><span class="text-xs">(per)</span></p>
                    </div>
                `).join('<div class="h-20 w-1 border-l border-[#e0e0e0] hidden md:block"></div>');

                        const bookingHTML = `
                    <a href="{{ url('/booking/${booking.id}/${booking.departure_point_id}/${booking.arrival_point_id}') }}" class="group flex flex-col items-start justify-between border-b border-[#e0e0e0] py-5 cursor-pointer mb-3">
                        <h1 class="group-hover:underline text-left text-xl font-bold text-[#07074D]">${booking.ship_name}</h1>
                        <h3 class="text-left text-base font-bold text-[#07074D]">${booking.departure_point} To ${booking.arrival_point}</h3>
                        <div class="flex flex-row justify-between items-start w-full mb-2">
                            <p class="text-sm text-[#07074D]"><span class="text-base font-bold">Date:</span> ${formatDate(booking.departure_date)}</p>
                            <p class="text-sm text-[#07074D]"><span class="text-base font-bold">Departure At:</span> ${formatTime(booking.departure_time)}</p>
                        </div>
                        <div class="flex flex-wrap justify-center md:justify-between items-center text-center w-full text-lg text-[#07074D] font-semibold bg-green-400 px-4 py-2 rounded-md gap-5 md:gap-0">
                            ${seatsHTML}
                        </div>
                    </a>
                `;

                        bookingItemsContainer.innerHTML += bookingHTML;
                    });

                    // Show the container
                    document.getElementById('available-bookings').classList.remove('hidden');
                } else {
                    errorToast('No bookings found for the selected criteria.');
                }
            } catch (error) {
                console.error('Error fetching bookings:', error);
                errorToast('An error occurred while fetching bookings.');
            }
        }
    </script>
