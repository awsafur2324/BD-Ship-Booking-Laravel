@extends('layouts.dashboard_layout')
@section('content')
    @include('components.dashboard.ship-assign.assignShip-form')
    {{-- model  --}}
    <div id="modelConfirm" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 ">
        <div class="relative top-32 mx-auto shadow-xl rounded-md bg-white max-w-md">
            <div class="flex flex-col p-5 rounded-lg shadow bg-white">
                <div class="flex justify-end p-2">
                    <button onclick="closeModal('modelConfirm')" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex">
                    <div>
                        <svg class="w-6 h-6 fill-current text-blue-500" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M11 7h2v2h-2zm0 4h2v6h-2zm1-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
                        </svg>
                    </div>

                    <div class="ml-3">
                        <h2 class="font-bold text-gray-800">Ship Assign Confirmation</h2>
                        <div class="mt-2 text-sm text-gray-600 leading-relaxed font-semibold flex flex-col gap-2">
                           <span> 1. One ship one refund policy</span>
                           <span> 2. One ship one Seat Map</span>
                           <span> 2. Manger have to provide the all necessary Information</span>
                           <span> 3. First Day provide data will set automatically for next 10 days</span>
                           <span> 4. Manger can change the data in the update anything if needed</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center mt-3">

                    <button onclick="closeModal('modelConfirm')"
                        class="px-4 py-2 ml-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md">
                        Continue
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            openModal('modelConfirm');
        })
        // Open modal
        window.openModal = function(modalId) {
            $('#' + modalId).show();
            $('body').addClass('overflow-y-hidden');
        }

        // Close modal
        window.closeModal = function(modalId) {
            $('#' + modalId).hide();
            $('body').removeClass('overflow-y-hidden');
        }

        // Close all modals when press ESC
        $(document).on('keydown', function(event) {
            if (event.keyCode === 27) {
                $('body').removeClass('overflow-y-hidden');
                $('.modal').hide();
            }
        });
    </script>
@endsection
