@extends('layouts.dashboard_layout')
@section('content')
    <div class="mx-auto my-8 flex flex-wrap justify-center items-center gap-5">
        {{-- total ship --}}
        <div class="pl-1 w-full sm:w-[40%] lg:w-[30%] h-20 bg-green-400 rounded-lg shadow-md">
            <div class="flex w-full h-full py-2 px-4 bg-white rounded-lg justify-between">
                <div class="my-auto">
                    <p class="font-bold">Total Booking</p>
                    <p class="text-lg">{{ $totalBooking }}</p>
                </div>
                <div class="my-auto">
                    <i class="fas fa-ship text-3xl text-green-400"></i>

                </div>
            </div>
        </div>
        {{-- total Booking --}}
        <div class="pl-1 w-full sm:w-[40%] lg:w-[30%] h-20 bg-green-400 rounded-lg shadow-md">
            <div class="flex w-full h-full py-2 px-4 bg-white rounded-lg justify-between">
                <div class="my-auto">
                    <p class="font-bold">Upcoming Booking</p>
                    <p class="text-lg">{{ $upcomingBooking }}</p>
                </div>
                <div class="my-auto">
                    <i class="fas fa-check-circle text-3xl text-green-400"></i>

                </div>
            </div>
        </div>
        {{-- total Earnings --}}
        <div class="pl-1 w-full sm:w-[40%] lg:w-[30%] h-20 bg-green-400 rounded-lg shadow-md">
            <div class="flex w-full h-full py-2 px-4 bg-white rounded-lg justify-between">
                <div class="my-auto">
                    <p class="font-bold">Total Refunds Amount</p>
                    <p class="text-lg">{{ $totalRefunds }}</p>
                </div>
                <div class="my-auto">
                    <i class="fas fa-dollar-sign text-3xl text-green-400"></i>

                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto my-8 w-full text-center ">
        <h3 class="text-center text-2xl font-bold mb-5">Payment Details</h3>
        <div class="relative bg-white rounded-lg shadow-md p-4">
            @if (empty($labels) || empty($data))
                <p class="text-red-500 ">No data available for the sales report.</p>
            @else
                <canvas id="myChart" width="400" height="200"></canvas>
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data from Laravel
            const totalAmounts = @json($totalAmounts);
            const payableAmounts = @json($payableAmounts);
            const discountAmounts = @json($discountAmounts);
            const totalRefunds = @json($totalRefunds);

            if (totalAmounts.length === 0 || payableAmounts.length === 0 || discountAmounts.length === 0 || totalRefunds.length === 0) {
                return;
            }
            // Chart configuration
            const data = {
                labels: ['Total Amount', 'Payable Amount', 'Discount Amount', 'Refunds Amount'],
                datasets: [{
                    label: 'Money Calculation',
                    data: [totalAmounts, payableAmounts, discountAmounts, totalRefunds],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 0, 0, 0.5)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(194, 8, 8, 1)',
                    ],
                    borderWidth: 2,
                }],
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Money View (Total, Payable, Discount ,Refunds)',
                        },
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Categories',
                            },
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Amount (BDT)',
                            },
                        },
                    },
                },
            };

            // Render the chart
            const myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
        });
    </script>
@endsection
