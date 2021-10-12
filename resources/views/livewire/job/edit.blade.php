{{-- Content --}}
<div class="py-12">
    <div class="mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <h2 class="font-semibold text-center mt-10 text-4xl text-gray-800 leading-tight">
                {{ ('Edit Job (ID: '. $job->id .')') }}
            </h2>

            {{-- Create Form --}}
            <div class="container p-5 sm:p-5 md:p-10 lg:p-20">
                <form class="w-full max-w-3xl mx-auto">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-name">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="job.name"
                                class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                id="grid-name" name="name" type="text" placeholder="Name" value="{{ $job->name }}"
                                required>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-description">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="job.description"
                                class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                id="grid-description" name="description" type="text" placeholder="Description"
                                value="{{ $job->description }}" required>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-content">
                                Content
                            </label>
                            <textarea wire:model="content"
                                class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                name="" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-amount">
                                Amount <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="job.amount"
                                class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                id="grid-description" name="amount" type="number" placeholder="Amount"
                                value="{{ $job->amount }}" required>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-salary">
                                Salary<span class="text-red-500">*</span>
                            </label>
                            <input wire:model="job.salary"
                                class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                id="grid-salary" name="salary" type="number" placeholder="Salary"
                                value="{{ $job->salary }}" required>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-optional-work-from-home">
                                Work from home <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="job.optional_work_from_home"
                                class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                id="grid-optional-work-from-home" name="optional_work_from_home" type="number" required>
                                <option class="py-1" value="{{ $job->optional_work_from_home === True ? 1 : 0 }}">
                                    Default {{ $job->optional_work_from_home === True ? "Yes" : "No" }}</option>
                                <option class="py-1" value="1">Yes</option>
                                <option class="py-1" value="0">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mt-5">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <div class="relative">
                                <button type="button" wire:click="updateJob"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mr-2 rounded">
                                    Update Job
                                </button>
                                <a href="{{ route('jobs.index') }}"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<style>
    trix-editor {
        min-height: 10rem !important;
        overflow-y: scroll !important;
        resize: vertical !important;
    }
</style>

<script>
    function onSubmitting() {
        document.getElementById('submitButton').innerHTML = `<i class="fas fa-spinner fa-spin"></i> Processing`;
    }
</script>