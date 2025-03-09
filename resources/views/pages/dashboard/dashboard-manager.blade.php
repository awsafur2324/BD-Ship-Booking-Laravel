@extends('layouts.dashboard_layout')
@section('content')
    <div class="mx-auto my-8 flex flex-wrap justify-center items-center gap-5">
        {{-- total ship --}}
        <div class="pl-1 w-full sm:w-[40%] lg:w-[30%] h-20 bg-green-400 rounded-lg shadow-md">
            <div class="flex w-full h-full py-2 px-4 bg-white rounded-lg justify-between">
                <div class="my-auto">
                    <p class="font-bold">My Total Ship</p>
                    <p class="text-lg">{{ $totalShip }}</p>
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
                    <p class="font-bold">My Successful Booking</p>
                    <p class="text-lg">{{ $successBooking }}</p>
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
                    <p class="font-bold">My Earnings</p>
                    <p class="text-lg ">{{ $totalEarning }}</p>
                </div>
                <div class="my-auto">
                    <i class="fas fa-dollar-sign text-3xl text-green-400"></i>

                </div>
            </div>
        </div>
    </div>

    {{-- Sales Report --}}
    <div class="mx-auto my-8 w-full text-center ">
        <h3 class="text-2xl font-bold text-gray-800 mb-5">Sales Report</h3>
        <div class="relative bg-white rounded-lg shadow-md p-4">
            @if (empty($labels) || empty($data))
                <p class="text-red-500 ">No data available for the sales report.</p>
            @else
                <canvas id="myChart" width="400" height="200"></canvas>
            @endif
        </div>
    </div>

    {{-- Download Buttons --}}
    <div class="flex flex-wrap justify-center items-center gap-5 my-5">
        @foreach ([['route' => 'export.manager.booking.history', 'label' => 'Download Booking History (CSV)'], ['route' => 'export.manager.sales.report', 'label' => 'Download Sales Report (CSV)'], ['route' => 'export.manager.refund.history', 'label' => 'Download Refund History (CSV)']] as $button)
            <div class="text-center my-5">
                <a href="{{ route($button['route']) }}"
                    class="px-4 py-2 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-600">
                    {{ $button['label'] }}
                </a>
            </div>
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            const labels = @json($labels);
            const data = @json($data);

            if (labels.length && data.length) {
                const config = {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Earnings (USD)',
                            data: data,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: '#2a9641',
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Date-Based Earnings Report'
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Earnings (USD)'
                                }
                            }
                        }
                    }
                };

                const myChart = new Chart(
                    document.getElementById('myChart'),
                    config
                );
            }
        });
    </script>
@endsection
