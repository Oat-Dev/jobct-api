<div x-data="{ isDeleteModalOpen: false }" x-init="document.getElementById('deleteModal').classList.remove('hidden')">
  <div class="flex flex-col">
    <div class="py-12 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Applicant ID
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Applicant name
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Job name
                </th>
                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Request Salary
                </th>
                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                  State
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  create_at
                </th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Action
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($applicants as $applicant)
              <tr>
                <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $applicant->user->id }}
                </td>
                <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $applicant->user->name }}
                </td>
                <td class="px-8 py-4 overflow-hidden text-sm text-gray-500">
                  {{ $applicant->job->name }}
                </td>
                <td class="px-10 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                  {{ $applicant->salary }}
                </td>
                <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-500">
                  <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    {{ $applicant->state }}
                  </span>
                </td>
                <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ \Carbon\Carbon::parse($applicant->created_at)->addyears(543)->locale('th')->isoFormat('lll') }}
                </td>
                <td class="px-8 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <a type="submit" href="/candidate/{{ $applicant->id }}" class="bg-gray-600 hover:bg-gray-800 text-white font-bold py-1 px-3 m-1 rounded">
                    View
                  </a>
                  @if($applicant->state != 'cancelled')
                  <button type="button" wire:click="$emit('openModalDeleteApplicantForm', {{ $applicant->id }})" class="bg-gray-600 hover:bg-red-800 text-white font-bold py-1 px-3 m-1 rounded">
                    Reject
                  </button>
                  @else
                  <button type="button" class="bg-gray-300 hover:bg-red-300 text-white font-bold py-1 px-3 m-1 rounded">
                    Reject
                  </button>
                  @endif
                </td>
              </tr>
              @endforeach

              @if(count($applicants) == 0)
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

  @livewire('candidates.reject')
  
</div>