{{-- Content --}}
<div class="py-12">
    <div class="mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl rounded-lg">
            <h2 class="font-semibold text-center mt-10 text-4xl text-gray-800 leading-tight">
                Date interview setting
            </h2>

            <div class="container p-5 sm:p-5 md:p-10 lg:p-20">

                {{-- interview date | interview time --}}
                <div class="flex flex-wrap -mx-3 mt-5 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Interview date<span class="text-red-500">*</span>
                        </label>
                        <input defaulDate="minDate:Today" type="date" class=" appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                               wire:model="applicant.interview_date" id="request_interview_date"
                               placeholder="YYYY-MM-DD">
                        @error('applicant.request_interview_date') <p class="text-red-500 text-xs italic">{{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Interview time<span class="text-red-500">*</span>
                        </label>
                        <input defaulDate="minDate:Today" type="time" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                               wire:model="applicant.interview_time" id="request_interview_time"
                               placeholder="H:i:s">
                        @error('applicant.request_interview_time') <p class="text-red-500 text-xs italic">{{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mt-5">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <div class="relative">
                            <button type="button" wire:click="save" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mr-2 rounded">
                                Confirm
                            </button>
                            <a href="{{ route('candidate.edit', ['id' => $applicant->id]) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        function initDatePicker() {
            flatpickr("#request_interview_date", { enableTime: false, dateFormat: "YYYY-MM-D" });
            flatpickr("#request_interview_time", {});
        }

        (function() {
            /initDatePicker();
        })();

        document.addEventListener('livewire:load', function() {
            initDatePicker();
        });
    </script>
</div>