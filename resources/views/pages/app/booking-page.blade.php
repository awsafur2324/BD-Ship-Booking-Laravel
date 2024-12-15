@extends('layouts.app_layout')
@section('content')
    @include('components.app.booking.ship_view')

    {{-- Refund Policy Modal --}}
    <div id="modelConfirm" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white max-w-md">
            <div class="flex flex-col p-5 rounded-lg shadow bg-white">
                <div class="flex justify-end p-2">
                    <button onclick="closeModal()" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex">
                    <div class="ml-3">
                        <h2 class="font-bold text-gray-800">Refund Policy</h2>
                        <div class="mt-2 text-sm text-gray-600 leading-relaxed font-semibold flex flex-col gap-2">
                            @foreach ($shipDetails as $ship)
                                @foreach ($ship['refund_policies'] as $policy)
                                    <span>{{ 1 + $loop->index }}. {{ $policy['refund_category'] }} Refund before
                                        {{ $policy['refund_time'] }} days of departure</span>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center mt-3">
                    <button onclick="closeModal()"
                        class="px-4 py-2 ml-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md">
                        Ok
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            document.querySelectorAll('.tab-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabId = this.dataset.tab;

                    // Hide all tab panes
                    document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.add(
                        'hidden'));

                    // Show selected tab pane
                    document.getElementById('tab' + tabId).classList.remove('hidden');

                    // Update active tab
                    document.querySelectorAll('.tab-link').forEach(link => link.classList.remove(
                        'text-gray-900', 'border-violet-600'));
                    this.classList.add('text-gray-900', 'border-violet-600');
                });
            });

            // Show first tab by default
            document.querySelector('.tab-link').click();



        });
    </script>
@endsection
