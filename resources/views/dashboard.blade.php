<x-app-layout>

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 border border-white rounded-lg overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 text-center">
                    <h1 class="text-2xl font-semibold text-green-600 dark:text-green-400 mb-4">
                        Selamat Datang!
                    </h1>
                    <p class="text-lg text-gray-700 dark:text-gray-300">
                        Anda berhasil login.
                    </p>
                    <p class="text-md text-gray-500 dark:text-gray-400 mt-2">
                        Role Anda: <strong>{{ auth()->user()->role }}</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>