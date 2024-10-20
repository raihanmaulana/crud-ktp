<!-- resources/views/no-access.blade.php -->
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 border border-white rounded-lg overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                <div class="text-center">
                    <h1 class="text-2xl font-semibold text-red-600 dark:text-red-400 mb-4">
                        Akses Ditolak
                    </h1>
                    <p class="text-lg text-gray-700 dark:text-gray-300">
                        Anda tidak memiliki akses ke halaman ini.
                    </p>
                    <p class="text-md text-gray-500 dark:text-gray-400 mt-2">
                        Role Anda: <strong>{{ $role }}</strong>
                    </p>
                </div>

                <!-- Tombol Kembali -->
                <div class="mt-6 text-center">
                    <a href="{{ route('dashboard') }}"
                        class="inline-block border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 px-4 py-2 rounded-md shadow-sm transition-colors duration-200">
                        Kembali ke Dashboard
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection