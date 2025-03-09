<aside class="w-full p-6 sm:w-60">
    <nav class="space-y-8 text-sm mb-10">
        <div class="space-y-2">
            <h2 class="text-sm font-semibold tracking-widest uppercase dark:text-gray-600">Dashboard</h2>
            <div class="flex flex-col space-y-1">
                @if (session('user_role') == 'admin')
                    <a href="{{ url('/dashboard/admin') }}"
                        class="{{ request()->is('dashboard/admin') ? 'text-blue-800 font-semibold' : '' }}">My
                        Dashboard</a>
                @elseif(session('user_role') == 'manager')
                    <a href="{{ url('/dashboard/manager') }}"
                        class="{{ request()->is('dashboard/manager') ? 'text-blue-800 font-semibold' : '' }}">My
                        Dashboard</a>
                @else
                    <a href="{{ url('/dashboard/user') }}"
                        class="{{ request()->is('dashboard/user') ? 'text-blue-800 font-semibold' : '' }}">My
                        Dashboard</a>
                @endif
            </div>
        </div>
        <div class="space-y-2">
            <h2 class="text-sm font-semibold tracking-widest uppercase dark:text-gray-600">My Bookings</h2>
            <div class="flex flex-col space-y-1">
                <a href="{{ url('/dashboard/my-Bookings') }}"
                    class="{{ request()->is('dashboard/my-Bookings') ? 'text-blue-800 font-semibold' : '' }}">My
                    Bookings</a>

                <a href="{{ url('/dashboard/refund-view') }}"
                    class="{{ request()->is('dashboard/refund-view') ? 'text-blue-800 font-semibold' : '' }}">My
                    Refunds</a>

            </div>
        </div>
        <div class="space-y-2">
            @if (session('user_role') == 'admin' || session('user_role') == 'manager')
                <h2 class="text-sm font-semibold tracking-widest uppercase dark:text-gray-600">Manage Ship</h2>
                <div class="flex flex-col space-y-1">
                    <a href="{{ url('/dashboard/ship-list') }}"
                        class="{{ request()->is('dashboard/ship-list') ? 'text-blue-800 font-semibold' : '' }}">Ship
                        List</a>
                    <a href="{{ url('/dashboard/ship-assign') }}"
                        class="{{ request()->is('dashboard/ship-assign') ? 'text-blue-800 font-semibold' : '' }}">Ship
                        Assign</a>
                    <a href="{{ url('/dashboard/add-day') }}"
                        class="{{ request()->is('dashboard/add-day') ? 'text-blue-800 font-semibold' : '' }}">Add
                        Day</a>
                    <a href="{{ url('/dashboard/ban-routes') }}"
                        class="{{ request()->is('dashboard/ban-routes') ? 'text-blue-800 font-semibold' : '' }}">Ban
                        Routes</a>
                </div>
            @endif
            @if (session('user_role') == 'admin')
                <div class="flex flex-col space-y-1">
                    <a href="{{ url('/dashboard/view-all-ships') }}"
                        class="{{ request()->is('dashboard/view-all-ships') ? 'text-blue-800 font-semibold' : '' }}">View
                        All Ships</a>
                </div>
            @endif
        </div>
        <div class="space-y-2 mb-5">
            <h2 class="text-sm font-semibold tracking-widest uppercase dark:text-gray-600">Management</h2>
            <div class="flex flex-col space-y-1 gap-1">
                @if (session('user_role') == 'admin')
                    <a href="{{ url('/dashboard/refund-request') }}"
                        class="{{ request()->is('dashboard/refund-request') ? 'text-blue-800 font-semibold' : '' }}">My
                        Refund Requests</a>
                    <a href="{{ url('/dashboard/refund-view-all') }}"
                        class="{{ request()->is('dashboard/refund-view-all') ? 'text-blue-800 font-semibold' : '' }}">My
                        Accepted Refunds</a>
                    <a href="{{ url('/dashboard/add-discount') }}"
                        class="{{ request()->is('dashboard/add-discount') ? 'text-blue-800 font-semibold' : '' }}">Add
                        Discount</a>
                    <a href="{{ url('/dashboard/discount-manager') }}"
                        class="{{ request()->is('dashboard/discount-manager') ? 'text-blue-800 font-semibold' : '' }}">Manager
                        Discount</a>
                    <a href="{{ url('/dashboard/verify-manager') }}"
                        class="{{ request()->is('dashboard/verify-manager') ? 'text-blue-800 font-semibold' : '' }}">Manager
                        Verification</a>
                    <a href="{{ url('/dashboard/view-all-managers') }}"
                        class="{{ request()->is('dashboard/view-all-managers') ? 'text-blue-800 font-semibold' : '' }}">Manager
                        List</a>
                @elseif(session('user_role') == 'manager')
                    <a href="{{ url('/dashboard/refund-request') }}"
                        class="{{ request()->is('dashboard/refund-request') ? 'text-blue-800 font-semibold' : '' }}">All
                        Refund Requests</a>
                    <a href="{{ url('/dashboard/refund-view-all') }}"
                        class="{{ request()->is('dashboard/refund-view-all') ? 'text-blue-800 font-semibold' : '' }}">All
                        Accepted Refunds</a>
                    <a href="{{ url('/dashboard/request-for-manager') }}"
                        class="{{ request()->is('dashboard/request-for-manager') ? 'text-blue-800 font-semibold' : '' }}">Request
                        For Manager</a>
                @else
                    <a href="{{ url('/dashboard/request-for-manager') }}"
                        class="{{ request()->is('dashboard/request-for-manager') ? 'text-blue-800 font-semibold' : '' }}">Request
                        For Manager</a>
                @endif

            </div>
        </div>
    </nav>
</aside>
