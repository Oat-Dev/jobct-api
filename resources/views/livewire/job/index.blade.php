<div x-data="{ isDeleteModalOpen: false }" x-init="document.getElementById('deleteModal').classList.remove('hidden')">
  <div class="flex flex-col">
    <div class="py-12 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <div class="flex justify-between content-center bg-white items-center px-4 py-2">
              {{-- Search Input --}}
              <div class="w-70">
                <div class="flex items-center">
                  <input wire:model="search"
                    class="search-input appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded-md py-2 lg:py-3 px-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" name="search" placeholder="Search..." aria-label="Search" autocomplete="off">
                </div>
              </div>
              {{-- Button --}}
              <div class="w-30">
                <a href="{{ route('jobs.create') }}"
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 lg:py-3 px-3 rounded">
                  <i class="fas fa-plus-circle mr-2"></i>Create
                </a>
              </div>
            </div>
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  ID
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Job Title
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Description
                </th>
                <th scope="col"
                  class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Salary
                </th>
                <th scope="col"
                  class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Amount
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  create_at
                </th>
                <th scope="col"
                  class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Action
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($jobs as $job)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $job->id }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    {{ $job->name }}
                  </span>
                </td>
                <td class="px-6 py-4 overflow-hidden text-sm text-gray-500">
                  {{ $job->description }}
                </td>
                <td class="px-10 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                  {{ number_format($job->salary) }}
                </td>
                <td class="px-10 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                  {{ $job->amount }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ \Carbon\Carbon::parse($job->created_at)->addyears(543)->locale('th')->isoFormat('lll') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <a type="submit" href="{{ route('jobs.edit', ['id' => $job->id]) }}"
                    class="bg-gray-600 hover:bg-gray-800 text-white font-bold py-1 px-3 m-1 rounded">
                    Edit
                  </a>
                  <button wire:click="$emit('openModalDeleteJobForm', {{ $job->id }})" type="button"
                    class="bg-gray-600 hover:bg-red-800 text-white font-bold py-1 px-3 m-1 rounded">
                    Delete
                  </button>
                </td>
              </tr>

              @endforeach
              @if (count($jobs) == 0)
              <td class="border border-gray-200 px-4 py-2 text-gray-400 text-center text-sm" colspan="7">
                Data not found
              </td>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  @livewire('job.destroy')
</div>