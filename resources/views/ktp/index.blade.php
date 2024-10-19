@extends('layouts.app')

@section('content')
<style>
    .pagination {
        display: flex;
        justify-content: center;
        padding-left: 0;
        list-style: none;
    }

    .pagination li {
        margin: 0 4px;
    }

    .pagination a,
    .pagination span {
        display: block;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.25;
        text-decoration: none;
        border-radius: 0.25rem;
        transition: background-color 0.2s, color 0.2s;
    }

    .pagination a {
        color: #4A90E2;
        /* Warna teks untuk link */
        background-color: #1F2937;
        /* Background sesuai dengan tema dark */
        border: 1px solid #374151;
        /* Border sesuai tema */
    }

    .pagination a:hover {
        background-color: #374151;
        /* Efek hover untuk link */
    }

    .pagination .active span {
        color: #fff;
        background-color: #4A90E2;
        /* Warna active sesuai tema */
        border-color: #4A90E2;
    }

    .pagination .disabled span {
        color: #6B7280;
        /* Warna teks untuk disabled */
        background-color: #1F2937;
        border-color: #374151;
        pointer-events: none;
    }
</style>


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">

            <div class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="min-w-full align-middle">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">NIK</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Alamat</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</span>
                                </th>
                            </tr>
                        </thead>

                        <tbody id="ktp-body" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <!-- Data akan dimuat melalui JavaScript -->
                        </tbody>
                    </table>
                </div>
                <input type="hidden" id="currentPage" value="{{ request('page', 1) }}">
                <div class="mt-2" id="pagination" class="mt-4 flex justify-center">
                    <!-- Pagination akan dimuat di sini -->
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Axios dan SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const initialPage = getQueryParameter('page'); // Ambil halaman dari URL
        loadKTPData(initialPage); // Muat data sesuai halaman

        async function loadKTPData(page = 1) {
            try {
                const response = await axios.get(`/api/ktp?page=${page}`);
                const ktps = response.data.data;
                const paginationLinks = response.data.links;
                const currentPage = response.data.meta.current_page; // Ambil current_page dari meta

                renderTable(ktps, currentPage); // Kirim currentPage ke renderTable
                renderPagination(paginationLinks);
            } catch (error) {
                console.error('Error fetching KTP data:', error);
            }
        }



        function getQueryParameter(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param) || 1; // Default ke halaman 1 jika tidak ada parameter
        }

        function renderTable(ktps, currentPage) {
            const tbody = document.getElementById('ktp-body');
            tbody.innerHTML = ''; // Bersihkan tabel sebelumnya

            ktps.forEach(ktp => {
                const row = `
            <tr class="bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${ktp.nama}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${ktp.nik}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${ktp.alamat}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <a href="/ktp/${ktp.id}?page=${currentPage}" class="text-blue-500 hover:underline">Lihat</a>
                    <a href="/ktp/${ktp.id}/edit?page=${currentPage}" class="ml-4 text-green-500 hover:underline">Edit</a>
                    <button type="button" onclick="deleteKTP(${ktp.id})" class="ml-4 text-red-500 hover:underline">Hapus</button>
                </td>
            </tr>
        `;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        }




        function renderPagination(links) {
            const paginationDiv = document.getElementById('pagination');
            paginationDiv.innerHTML = ''; // Bersihkan pagination sebelumnya

            const ul = document.createElement('ul');
            ul.classList.add('pagination'); // Tambahkan class pagination

            links.forEach(link => {
                const li = document.createElement('li');
                li.classList.add('page-item'); // Class untuk item pagination

                const anchor = document.createElement('a');
                anchor.classList.add('page-link'); // Class untuk link pagination

                if (link.active) {
                    li.classList.add('active');
                    anchor.innerHTML = `<span>${link.label}</span>`;
                } else if (link.url) {
                    anchor.href = '#';
                    anchor.innerHTML = link.label;
                    anchor.onclick = (e) => {
                        e.preventDefault();
                        const page = getPageNumber(link.url); // Ambil halaman dari URL
                        loadKTPData(page); // Muat data untuk halaman yang sesuai
                    };
                } else {
                    li.classList.add('disabled');
                    anchor.innerHTML = `<span>${link.label}</span>`;
                }

                li.appendChild(anchor);
                ul.appendChild(li);
            });

            paginationDiv.appendChild(ul);
        }


        function getPageNumber(url) {
            const params = new URLSearchParams(url.split('?')[1]);
            return params.get('page') || 1;
        }



        window.deleteKTP = function(id) {
            const currentPage = document.getElementById('currentPage').value; // Ambil nilai page
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data KTP akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        await axios.delete(`/api/ktp/${id}`, {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        Swal.fire('Terhapus!', 'Data KTP berhasil dihapus.', 'success');
                        loadKTPData(currentPage); // Muat ulang data untuk halaman yang sama tanpa refresh
                    } catch (error) {
                        console.error('Error deleting KTP:', error);
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                    }
                }
            });
        };

    });
</script>
@endsection