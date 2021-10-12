<div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>

<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 h-auto transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex items-center justify-center mt-8">
        <div class="flex items-center">
            <span class="text-white text-2xl mx-2 font-semibold">Dashboard</span>
        </div>
    </div>

    <nav class="mt-10">
        <a class="flex items-center mt-4 py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 @if(\Request::is('dashboard')) bg-gray-100 bg-gray-600 bg-opacity-25 text-gray-100 font-bold @else text-gray-500 @endif" href="{{ route('dashboard') }}">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
            </svg>

            <span class="mx-3">Dashboard</span>
        </a>

        <a class="flex items-center mt-4 py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 @if(\Request::is('jobs')) bg-gray-100 bg-gray-600 bg-opacity-25 text-gray-100 font-bold @else text-gray-500 @endif" href="{{ route('jobs.index') }}">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
            </svg>

            <span class="mx-3">Job</span>
        </a>

        <a class="flex items-center mt-4 py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 @if(\Request::is('candidate')) bg-gray-100 bg-gray-600 bg-opacity-25 text-gray-100 font-bold @else text-gray-500 @endif" href="{{ route('candidate.index') }}">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>

            <span class="mx-3">Candidate</span>
        </a>
        <a class="flex items-center py-3 px-6 pl-10 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 @if(\Request::is('candidate/interview/approve')) bg-gray-100 bg-gray-700 bg-opacity-75 text-gray-100 font-bold @else bg-gray-100 bg-gray-700 bg-opacity-25 text-gray-400 @endif"href="{{ route('candidate.candidates-approve-lists') }}">
            <i class="fas fa-circle fa-xxs"></i>
            <span class="mx-3 text-sm">Candidate Approve List</span>
        </a>
        <a class="flex items-center py-3 px-6 pl-10 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 @if(\Request::is('candidate/interview/finish')) bg-gray-100 bg-gray-700 bg-opacity-75 text-gray-100 font-bold @else bg-gray-100 bg-gray-700 bg-opacity-25 text-gray-400 @endif"href="{{ route('candidate.candidates-finish-lists') }}">
            <i class="fas fa-circle fa-xxs"></i>
            <span class="mx-3 text-sm">Candidate Finish List</span>
        </a>

        <a class="flex items-center mt-4 py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 @if(\Request::is('user/profile')) bg-gray-100 bg-gray-600 bg-opacity-25 text-gray-100 font-bold @else text-gray-500 @endif" href="{{ route('profile.show') }}">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>

            <span class="mx-3">Account</span>
        </a>
    </nav>
</div>