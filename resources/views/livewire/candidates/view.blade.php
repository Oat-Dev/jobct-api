{{-- Content --}}
<div class="py-12">
    <div class="mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <h2 class="font-semibold text-center mt-10 text-4xl text-gray-800 leading-tight">
                {{ ('View Applicant (ID: '. $applicant->job->id .')') }}
            </h2>

            <div wire:loading wire:target="changeStep,nextStep,backStep" class="w-full text-center">
                <p><i class="fas fa-spinner fa-spin fa-2x text-xs mr-2"></i></p>
            </div>

            {{-- Create Form --}}
            <div class="container p-5 sm:p-5 md:p-10 lg:p-20">
                <div class="w-full max-w-3xl mx-auto">
                    {{ csrf_field() }}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="grid-name">
                                Applicant name : {{ $applicant->user->name }}
                            </label>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="grid-name">
                                Job Name : {{ $applicant->job->name }}
                            </label>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="grid-salary">
                                Expected salary : {{ number_format($applicant->salary) }}
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="grid-work-from-home">
                                Work from home : {{ $applicant->job->optional_work_from_home ? 'True' : 'False' }}
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="grid-request-interview-date">
                                Interview date : {{ \Carbon\Carbon::parse($applicant->request_interview_date)->addyears(543)->locale('th')->isoFormat('LL') ?? 'No fill out' }}
                            </label>
                            <label class="block uppercase tracking-wide text-gray-700 text-xl font-bold mb-2" for="grid-request-interview-time">
                                Interview time : {{ \Carbon\Carbon::parse($applicant->request_interview_time)->locale('th')->isoFormat('LT') ?? 'No fill out' }}
                            </label>
                        </div>
                    </div>

                    <!-- Current CV files -->
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xl text-center font-bold mb-4 mt-5" for="grid-cv-file">
                                CV/Resume File
                            </label>
                        </div>
                        @if(Storage::disk('do_spaces')->exists($applicant->user->cv_path) == Null)
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xl text-center font-bold mb-4 mt-5" for="grid-cv-file">
                                No file CV/Resume
                            </label>
                        </div>
                        @elseif (Storage::disk('do_spaces')->getMimeType($applicant->user->cv_path) === 'image/jpeg')
                        <div class="mt-2">
                            <a href="{{ Storage::disk('do_spaces')->url($applicant->user->cv_path) }}" class="rounded h-full object-cover inline" target="_blank" Download>
                                <img src="{{ Storage::disk('do_spaces')->url($applicant->user->cv_path) }}" class="rounded h-full object-cover object-center object-scale-down inline" style="height: 800px; width:max-content;" />
                            </a>
                        </div>
                        @elseif (Storage::disk('do_spaces')->getMimeType($applicant->user->cv_path) === 'application/pdf')
                        <div class="mt-2">
                            <a href="{{ Storage::disk('do_spaces')->url($applicant->user->cv_path) }}" class="rounded h-full object-cover inline" target="_blank" Download>
                            <center>
                                <embed src="{{ Storage::disk('do_spaces')->url($applicant->user->cv_path) }}" class="rounded h-full object-cover object-center object-scale-down inline" style="height: 400px; margin: 0 auto; width:max-content;">
                                </embed>
                            </center>
                            </a>
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap -mx-3 mt-5">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <div class="relative">
                                <a type="button" href="{{ route('candidate.date-interview-setting', ['id' => $applicant->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mr-2 rounded">
                                    Approve
                                </a>
                                @if($applicant->state != 'cancelled')
                                <button type="button" wire:click="$emit('openModalDeleteApplicantForm', {{ $applicant->id }})" class="bg-gray-600 hover:bg-red-800 text-white font-bold py-2 px-4 m-1 rounded">
                                    Reject
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @livewire('candidates.reject')
</div>

<style>
    img,
    svg,
    video,
    canvas,
    audio,
    iframe,
    embed,
    object {
        display: block;
        vertical-align: middle;
    }
</style>