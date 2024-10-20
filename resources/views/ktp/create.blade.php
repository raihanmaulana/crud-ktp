@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 border border-white rounded-lg overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                    Tambah Data KTP
                </h1>

                <!-- Form Tambah KTP -->
                <form id="ktpForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                        <input type="text" name="nama" id="nama" required
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:text-gray-100">
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                        <input type="text" name="alamat" id="alamat" required
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:text-gray-100">
                    </div>

                    <div class="mb-4">
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" required
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:text-gray-100">
                    </div>

                    <div class="mb-4">
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" required
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:text-gray-100">
                    </div>

                    <div class="mb-4">
                        <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload Foto</label>
                        <input type="file" name="foto" id="foto" accept="image/*"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:text-gray-100">
                    </div>

                    <div class=>
                        <button type="submit"
                            class="inline-block w-full sm:w-auto border border-gray-300 dark:border-gray-600 bg-green-400 text-white hover:bg-green-500 hover:border-green-500 px-4 py-2 rounded-md shadow-sm transition-colors duration-200">
                            Simpan
                        </button>

                        <a href="{{ route('ktp.index', ['page' => request('page')]) }}"
                            class="mt-4 ml-2 inline-block border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 px-4 py-2 rounded-md shadow-sm transition-colors duration-200">
                            Batal
                        </a>
                    </div>

                </form>

                <div id="successMessage" class="hidden mt-4 text-green-600 dark:text-green-400">
                    Data KTP berhasil ditambahkan!
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Script AJAX -->
<script>
    document.getElementById('ktpForm').addEventListener('submit', async function(e) {
        e.preventDefault(); // Mencegah form reload

        let formData = new FormData(this); // Ambil data form

        try {
            const response = await fetch("{{ route('ktp.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            if (response.ok) {
                // Tampilkan pesan sukses
                document.getElementById('successMessage').classList.remove('hidden');

                // Redirect ke halaman index setelah 2 detik
                setTimeout(() => {
                    window.location.href = "/ktp";
                }, 2000);
            } else {
                const errorData = await response.json();
                alert('Terjadi kesalahan: ' + JSON.stringify(errorData));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan dalam proses pengiriman data.');
        }
    });
</script>
@endsection