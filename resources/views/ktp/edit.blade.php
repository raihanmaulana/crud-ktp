@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">


                <!-- Pesan Sukses atau Error -->
                <div id="message" class="mb-4 hidden"></div>

                <div class="overflow-hidden overflow-x-auto">
                    <form id="editKTPForm">
                        @csrf
                        @method('PUT')
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Field</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Input</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr class="bg-white dark:bg-gray-900">
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900 dark:text-gray-300">Nama</td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900 dark:text-gray-300">
                                        <input type="text" name="nama" value="{{ old('nama', $ktp->nama) }}" required class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 rounded-md shadow-sm p-2">
                                    </td>
                                </tr>
                                <tr class="bg-white dark:bg-gray-900">
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900 dark:text-gray-300">NIK</td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900 dark:text-gray-300">
                                        <input type="text" name="nik" value="{{ old('nik', $ktp->nik) }}" required class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 rounded-md shadow-sm p-2">
                                    </td>
                                </tr>
                                <tr class="bg-white dark:bg-gray-900">
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900 dark:text-gray-300">Alamat</td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900 dark:text-gray-300">
                                        <input type="text" name="alamat" value="{{ old('alamat', $ktp->alamat) }}" required class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 rounded-md shadow-sm p-2">
                                    </td>
                                </tr>
                                <tr class="bg-white dark:bg-gray-900">
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900 dark:text-gray-300">Tempat Lahir</td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900 dark:text-gray-300">
                                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $ktp->tempat_lahir) }}" required class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 rounded-md shadow-sm p-2">
                                    </td>
                                </tr>
                                <tr class="bg-white dark:bg-gray-900">
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900 dark:text-gray-300">Tanggal Lahir</td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-gray-900 dark:text-gray-300">
                                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $ktp->tanggal_lahir) }}" required class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 rounded-md shadow-sm p-2">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="page" value="{{ request('page', 1) }}">
                        <div class="mt-4">
                            <!-- Tombol Simpan -->
                            <button type="submit"
                                class="mt-4 inline-block border border-green-400 bg-green-400 text-white hover:bg-green-500 hover:border-green-500 px-4 py-2 rounded-md shadow-sm transition-colors duration-200">
                                Simpan
                            </button>

                            <!-- Tombol Batal -->
                            <a href="{{ route('ktp.index', ['page' => request('page')]) }}"
                                class="mt-4 ml-4 inline-block border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 px-4 py-2 rounded-md shadow-sm transition-colors duration-200">
                                Batal
                            </a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    document.getElementById('editKTPForm').addEventListener('submit', async function(e) {
        e.preventDefault(); // Cegah refresh halaman

        const form = e.target;
        const data = new FormData(form);

        // Tambahkan _method=PUT agar Laravel mengenali metode PUT
        data.append('_method', 'PUT');

        const jsonData = Object.fromEntries(data.entries());

        // Ambil parameter 'page' dari input hidden dan URL
        const pageFromInput = form.querySelector('input[name="page"]').value;
        console.log('Page from input:', pageFromInput); // Debugging

        try {
            const response = await axios.post(`{{ url('/api/ktp/' . $ktp->id) }}?page=${pageFromInput}`, jsonData, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (response.status === 200) {
                showMessage(response.data.message, 'success');

                // Redirect ke halaman yang diterima dari API setelah 2 detik
                const page = response.data.page || pageFromInput;
                console.log(`Redirecting to: /ktp?page=${page}`); // Debugging

                setTimeout(() => {
                    window.location.href = `/ktp?page=${page}`;
                }, 2000);
            }
        } catch (error) {
            console.error('Update Error:', error);
            const message = error.response?.data?.message || 'Terjadi kesalahan saat memperbarui KTP.';
            showMessage(message, 'error');
        }
    });




    function showMessage(message, type) {
        const messageDiv = document.getElementById('message');
        messageDiv.textContent = message;
        messageDiv.className = type === 'success' ? 'text-green-600' : 'text-red-600';
        messageDiv.classList.remove('hidden');
    }
</script>
@endsection