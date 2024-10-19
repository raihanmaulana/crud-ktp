@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Import Data KTP</h2>

                <p class="mb-6 text-gray-600 dark:text-gray-300">
                    Upload file CSV untuk mengimpor data KTP ke dalam sistem.
                </p>

                <!-- Div Notifikasi -->
                <div id="message" class="hidden mb-4 font-semibold"></div>

                <form id="importCsvForm" enctype="multipart/form-data">
                    @csrf
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-300 dark:border-gray-600">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    File CSV
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                    <input type="file" name="file" accept=".csv" required
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Import CSV
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    document.getElementById('importCsvForm').addEventListener('submit', async function(e) {
        e.preventDefault(); // Cegah refresh halaman

        const form = e.target;
        const formData = new FormData(form);

        try {
            const response = await axios.post(`{{ route('import.csv') }}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            showMessage(response.data.message, 'success');
        } catch (error) {
            console.error(error);
            const message = error.response?.data?.message || 'Terjadi kesalahan saat mengimpor data.';
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