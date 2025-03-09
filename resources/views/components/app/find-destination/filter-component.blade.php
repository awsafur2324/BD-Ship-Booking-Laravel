<div class="bg-white px-3 py-5 flex flex-wrap justify-center items-center gap-8">
    <div class="flex flex-row justify-between items-center w-full">
        <div class="text-left text-[#000000ab] w-full">
            <i class="fas fa-filter"></i> Filter by:
        </div>
        <p class="block lg:hidden rounded-full bg-gray-200 px-1.5 cursor-pointer" onclick="toggleFilter()">&times;</p>
    </div>

    {{-- Search by ship name --}}
    <div class="w-full sm:max-w-96 bg-white relative">
        <div class="relative bg-inherit">
            <input type="text" id="ship_name" name="ship_name"
                class="peer bg-transparent h-10 w-full rounded-sm text-gray-800 placeholder-transparent ring-2 px-2 ring-gray-500 focus:ring-sky-600 focus:outline-none focus:border-rose-600"
                placeholder="Type inside me" onkeyup="fetchSuggestions(this, 'ship')" />
            <label for="ship_name"
                class="absolute cursor-text left-0 -top-3 text-sm text-gray-500 bg-inherit mx-1 px-1 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-sky-600 peer-focus:text-sm transition-all">
                Search by ship name
            </label>
            <ul id="ship_name_suggestions" class="absolute z-10 mt-1 bg-white shadow-lg rounded-sm w-full hidden"></ul>
        </div>
    </div>

    {{-- Departure From --}}
    <div class="w-full sm:max-w-96 bg-white relative">
        <div class="relative bg-inherit">
            <input type="text" id="departure_from" name="departure_from"
                class="peer bg-transparent h-10 w-full rounded-sm text-gray-800 placeholder-transparent ring-2 px-2 ring-gray-500 focus:ring-sky-600 focus:outline-none focus:border-rose-600"
                placeholder="Type inside me" onkeyup="fetchSuggestions(this, 'departure')" />
            <label for="departure_from"
                class="absolute cursor-text left-0 -top-3 text-sm text-gray-500 bg-inherit mx-1 px-1 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-sky-600 peer-focus:text-sm transition-all">
                Enter Departure From
            </label>
            <ul id="departure_from_suggestions" class="absolute z-10 mt-1 bg-white shadow-lg rounded-sm w-full hidden"></ul>
        </div>
    </div>

    {{-- Arrival To --}}
    <div class="w-full sm:max-w-96 bg-white relative">
        <div class="relative bg-inherit">
            <input type="text" id="arrival_to" name="arrival_to"
                class="peer bg-transparent h-10 w-full rounded-sm text-gray-800 placeholder-transparent ring-2 px-2 ring-gray-500 focus:ring-sky-600 focus:outline-none focus:border-rose-600"
                placeholder="Type inside me" onkeyup="fetchSuggestions(this, 'arrival')" />
            <label for="arrival_to"
                class="absolute cursor-text left-0 -top-3 text-sm text-gray-500 bg-inherit mx-1 px-1 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-sky-600 peer-focus:text-sm transition-all">
                Enter Arrival Point
            </label>
            <ul id="arrival_to_suggestions" class="absolute z-10 mt-1 bg-white shadow-lg rounded-sm w-full hidden"></ul>
        </div>
    </div>

    {{-- Departure Date Search --}}
    <div class="w-full sm:max-w-96 bg-white">
        <div class="relative bg-inherit">
            <input type="date" id="start_date" name="start_date"
                class="peer bg-transparent h-10 w-full rounded-sm text-gray-800 placeholder-transparent ring-2 px-2 ring-gray-500 focus:ring-sky-600 focus:outline-none focus:border-rose-600"
                placeholder="Type inside me" />
            <label for="start_date"
                class="absolute cursor-text left-0 -top-3 text-sm text-gray-500 bg-inherit mx-1 px-1 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-sky-600 peer-focus:text-sm transition-all">
                Enter A Date
            </label>
        </div>
    </div>
    <div class="w-full sm:max-w-96 text-center text-sm text-gray-500">------To------</div>
    {{-- Another End Departure date --}}
    <div class="w-full sm:max-w-96 bg-white">
        <div class="relative bg-inherit">
            <input type="date" id="end_date" name="end_date"
                class="peer bg-transparent h-10 w-full rounded-sm text-gray-800 placeholder-transparent ring-2 px-2 ring-gray-500 focus:ring-sky-600 focus:outline-none focus:border-rose-600"
                placeholder="Type inside me" />
            <label for="end_date"
                class="absolute cursor-text left-0 -top-3 text-sm text-gray-500 bg-inherit mx-1 px-1 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-sky-600 peer-focus:text-sm transition-all">
                Enter A Date
            </label>
        </div>
    </div>

    {{-- Guest Number --}}
    <div class="w-full sm:max-w-96 bg-white">
        <div class="relative bg-inherit">
            <input type="number" id="guest_number" name="guest_number"
                class="peer bg-transparent h-10 w-full rounded-sm text-gray-800 placeholder-transparent ring-2 px-2 ring-gray-500 focus:ring-sky-600 focus:outline-none focus:border-rose-600"
                placeholder="Type inside me" />
            <label for="guest_number"
                class="absolute cursor-text left-0 -top-3 text-sm text-gray-500 bg-inherit mx-1 px-1 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-sky-600 peer-focus:text-sm transition-all">
                How many guests?
            </label>
        </div>
    </div>

    <button
        class="w-full px-10 py-2.5 relative rounded group overflow-hidden font-medium bg-purple-50 text-purple-600 inline-block"
        onclick="onFilterChange()">
        <span
            class="absolute top-0 left-0 flex w-full h-0 mb-0 transition-all duration-200 ease-out transform translate-y-0 bg-purple-600 group-hover:h-full opacity-90"></span>
        <span class="relative group-hover:text-white">Filters</span>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the current date in YYYY-MM-DD format
        var currentDate = new Date();

        // Adjust the date to the format YYYY-MM-DD
        var day = ("0" + currentDate.getDate()).slice(-2);
        var month = ("0" + (currentDate.getMonth() + 1)).slice(-2); // Months are 0-based, so add 1
        var year = currentDate.getFullYear();

        // Combine them into the correct format
        var formattedDate = year + "-" + month + "-" + day;

        // Set the min attribute for the date input fields
        document.getElementById('start_date').setAttribute('min', formattedDate);
        document.getElementById('end_date').setAttribute('min', formattedDate);
    });

    function fetchSuggestions(input, type) {
        const query = input.value.trim();
        const suggestionList = document.getElementById(`${input.id}_suggestions`);

        if (query.length === 0) {
            suggestionList.classList.add('hidden');
            return;
        }

        let endpoint = '';
        if (type === 'ship') endpoint = '/api/suggest-ship-name';
        else if (type === 'departure') endpoint = '/api/suggest-departure-from';
        else if (type === 'arrival') endpoint = '/api/suggest-arrival-to';

        fetch(`${endpoint}?query=${encodeURIComponent(query)}`)
            .then((response) => response.json())
            .then((data) => {
                if (data.length > 0) {
                    suggestionList.innerHTML = data
                        .map((item) =>
                            `<li class="px-2 py-1 hover:bg-gray-200 cursor-pointer" onclick="selectSuggestion('${input.id}', '${item}')">${item}</li>`
                            )
                        .join('');
                    suggestionList.classList.remove('hidden');
                } else {
                    suggestionList.innerHTML = `<li class="px-2 py-1 text-gray-500">No results found</li>`;
                }
            });
    }

    function selectSuggestion(inputId, value) {
        const input = document.getElementById(inputId);
        const suggestionList = document.getElementById(`${inputId}_suggestions`);
        input.value = value;
        suggestionList.classList.add('hidden');
    }
</script>
