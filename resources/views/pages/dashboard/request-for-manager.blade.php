@extends('layouts.dashboard_layout')
@section('content')
    <div class="">
        <div class="container mx-auto px-2 ">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full px-4">
                    <div class="shadow-lg p-5 bg-white rounded-lg">
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex-1">
                                <h4 class="text-black text-center font-bold text-2xl">Wanted to be a Manager</h4>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full pt-3 table-auto border-collapse " id="tableData">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2">No</th>
                                        <th class="border border-gray-200 px-4 py-2">Your Name</th>
                                        <th class="border border-gray-200 px-4 py-2">Role</th>
                                        <th class="border border-gray-200 px-4 py-2">Email Verified</th>
                                        <th class="border border-gray-200 px-4 py-2">Manager Verified</th>
                                        <th class="border border-gray-200 px-4 py-2 text-center">Request Status</th>
                                        <th class="border border-gray-200 px-4 py-2 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableList" class="bg-white"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            loadData();
    
            async function loadData() {
                try {
                    const res = await axios.get('/api/get-user-info');
                    let tableList = $("#tableList");
                    let tableData = $("#tableData");
    
                    // Destroy DataTable if it already exists
                    if ($.fn.DataTable.isDataTable('#tableData')) {
                        tableData.DataTable().destroy();
                    }
                    tableList.empty();
    
                    let data = res.data;
                    if (data.length === 0) {
                        tableList.append(`
                            <tr>
                                <td colspan="6" class="text-center text-gray-500">Please Request fast</td>
                            </tr>
                        `);
                        return;
                    }
    
                    data.forEach((user, index) => {
                        let row = `
                            <tr data-user-id="${user.id}">
                                 <td class="border border-gray-200 px-4 py-2">${index + 1}</td>
                                 <td class="border border-gray-200 px-4 py-2">${user.name}</td>
                                 <td class="border border-gray-200 px-4 py-2">${user.role}</td>
                                 <td class="border border-gray-200 px-4 py-2">${user.email_verified}</td>
                                 <td class="border border-gray-200 px-4 py-2">${user.manager_verified === '' ? 'No' : 'Yes'}</td>
                                 <td class="border border-gray-200 px-4 py-2">${user.manager_status}</td>
                                 <td class="border border-gray-200 px-4 py-2">
                                    ${
                                        user.manager_status === 'inactive'
                                            ? `<button class="request-btn bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                Request
                                               </button>`
                                            : 'Request Sent'
                                    }
                                </td>
                            </tr>
                        `;
                        tableList.append(row);
                    });
    
                    // Initialize DataTable
                    new DataTable('#tableData', {
                        responsive: true,
                        autoWidth: false,
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
    
                    // Attach click event to Request buttons
                    $(".request-btn").on("click", async function () {
                        const userId = $(this).closest("tr").data("user-id");
                        try {
                            const response = await axios.get('/api/request-manager-To-pending');
                            if (response.data.success) {
                                successToast('Request sent successfully!');
                                loadData(); // Reload the table
                            } else {
                                errorToast('Failed to send the request. Try again.');
                            }
                        } catch (error) {
                            errorToast('An error occurred. Please try again.');
                        }
                    });
                } catch (error) {
                    console.error("Error loading data:", error);
                }
            }
        });
    </script>
@endsection
