<aside class="w-full p-6 sm:w-60">
    <nav class="space-y-8 text-sm mb-10">
        <div class="space-y-2">
            <h2 class="text-sm font-semibold tracking-widest uppercase dark:text-gray-600">Dashboard</h2>
            <div class="flex flex-col space-y-1">
                <a href="{{ url('/dashboard') }}"
                    class="{{ request()->is('dashboard') ? 'text-blue-800 font-semibold' : '' }}">My Dashboard</a>
            </div>
        </div>
        <div class="space-y-2">
            <h2 class="text-sm font-semibold tracking-widest uppercase dark:text-gray-600">My Bookings</h2>
            <div class="flex flex-col space-y-1">
                <a href="{{ url('/dashboard/my-Bookings') }}">My Bookings</a>
                <a href="#">My Tickets</a>
                <a href="#">My Refunds</a>
            </div>
        </div>
        <div class="space-y-2">
            <h2 class="text-sm font-semibold tracking-widest uppercase dark:text-gray-600">Manage Ship</h2>
            <div class="flex flex-col space-y-1">
                <a href="#">Ship List</a>
                <a href="{{ url('/dashboard/ship-assign') }}">Ship Assign</a>
                <a href="#">Ship Update</a>
            </div>
        </div>
        <div class="space-y-2 mb-5">
            <h2 class="text-sm font-semibold tracking-widest uppercase dark:text-gray-600">Management</h2>
            <div class="flex flex-col space-y-1">
                <a href="#">All Refund Requests</a>
                <a href="#">Request For Manager</a>
                <a href="#">All Request For Manager</a>
                <a href="#">Add Discount Offer</a>
            </div>
        </div>
    </nav>
</aside>
