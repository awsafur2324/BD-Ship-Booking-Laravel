@extends('layouts.dashboard_layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow px-5 py-5">
                <div class="row justify-content-between mb-3">
                    <div class="col">
                        <h4 class="text-primary">My Bookings</h4>
                    </div>
                </div>
                <hr />
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover w-100" id="tableData">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Ship Name</th>
                                <th>Departure Point</th>
                                <th>Seats</th>
                                <th>Price</th>
                                <th>Ship Manager Name</th>
                                <th>Ship Manager Mobile</th>
                            </tr>
                        </thead>
                        <tbody id="tableList"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
getList();

async function getList() {
    showLoader(); // Ensure you have a `showLoader()` function defined
    try {
        let res = await axios.get("/api/booking/list");
        hideLoader(); // Ensure you have a `hideLoader()` function defined
        console.log(res.data);
        let tableList = $("#tableList");
        let tableData = $("#tableData");

        // Destroy DataTable if it already exists
        if ($.fn.DataTable.isDataTable('#tableData')) {
            tableData.DataTable().destroy();
        }
        tableList.empty();

        let data = res.data.data; // Assuming grouped response is in 'data' key
        if (data.length === 0) {
            tableList.append(`
                <tr>
                    <td colspan="7" class="text-center text-muted">No bookings available.</td>
                </tr>
            `);
            return;
        }

        let rowIndex = 0;
        data.forEach((group) => {
            group.bookings.forEach((booking) => {
                rowIndex++;
                let row = `
                    <tr>
                        <td>${rowIndex}</td>
                        <td>${group.ship_name}</td>
                        <td>${group.departure_point}</td>
                        <td>${booking.seats}</td>
                        <td>${booking.price} BDT</td>
                        <td>${group.ship_manager_name}</td>
                        <td>${group.ship_manager_mobile}</td>
                    </tr>
                `;
                tableList.append(row);
            });
        });

        // Initialize DataTable
        new DataTable('#tableData', {
            responsive: true, // Enables responsive table behavior
            autoWidth: false, // Prevents fixed width issues
            order: [[0, 'desc']],
            lengthMenu: [5, 10, 15, 20],
            paging: true,
            searching: true,
            language: {
                paginate: {
                    next: 'Next →',
                    previous: '← Previous',
                },
                search: 'Search:',
                lengthMenu: 'Show _MENU_ entries',
                zeroRecords: 'No matching records found',
            },
        });
    } catch (error) {
        hideLoader();
        console.error(error);
        alert('Failed to load bookings. Please try again.');
    }
}
</script>
@endsection
