<!-- resources/views/ktp/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 border border-white rounded-lg overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                <div class="overflow-hidden overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Detail</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Informasi</span>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr class="bg-white dark:bg-gray-900">
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-300">
                                    Nama
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-300">
                                    {{ $ktp->nama }}
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-gray-900">
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-300">
                                    NIK
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-300">
                                    {{ $ktp->nik }}
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-gray-900">
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-300">
                                    Alamat
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-300">
                                    {{ $ktp->alamat }}
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-gray-900">
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-300">
                                    Tempat Lahir
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-300">
                                    {{ $ktp->tempat_lahir }}
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-gray-900">
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-300">
                                    Tanggal Lahir
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-300">
                                    {{ $ktp->tanggal_lahir }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <input type="hidden" id="page" value="{{ request('page', 1) }}">
                <!-- Tombol Kembali -->
                <a href="{{ route('ktp.index', ['page' => request('page', 1)]) }}"
                    class="mt-4 inline-block border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 px-4 py-2 rounded-md shadow-sm transition-colors duration-200">
                    Kembali
                </a>

            </div>
        </div>
    </div>
</div>
@endsection