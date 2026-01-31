<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Digital Printing - CV Anugrah Mandiri</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Optional: Heroicons for icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Sidebar -->
    <div class="flex">
        <aside class="w-64 bg-white h-screen shadow-lg flex flex-col">
            <div class="flex items-center justify-center h-20 border-b">
                <img src="{{ asset('images/logo-cv.png') }}" alt="CV Anugrah Mandiri" class="h-12">
            </div>
            <nav class="flex-1 px-4 py-6">
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-600">
                            <span class="material-icons mr-2">dashboard</span>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-600">
                            <span class="material-icons mr-2">inventory_2</span>
                            Pesanan
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-600">
                            <span class="material-icons mr-2">receipt</span>
                            Laporan
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-600">
                            <span class="material-icons mr-2">settings</span>
                            Pengaturan
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="px-4 py-4 border-t">
                <a href="{{ route('logout') }}" class="block text-center text-red-600 hover:text-white hover:bg-red-600 font-semibold py-2 rounded-lg transition">
                    Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Digital Printing</h1>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-gray-500">Pesanan Hari Ini</p>
                    <h2 class="text-2xl font-bold text-gray-800">28</h2>
                </div>
                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-gray-500">Rata-rata Konfirmasi</p>
                    <h2 class="text-2xl font-bold text-gray-800">2,1 jam</h2>
                </div>
                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-gray-500">Tingkat Revisi</p>
                    <h2 class="text-2xl font-bold text-gray-800">18%</h2>
                </div>
                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-gray-500">Total Pendapatan</p>
                    <h2 class="text-2xl font-bold text-gray-800">Rp 12.500.000</h2>
                </div>
            </div>

            <!-- Pesanan Terbaru Table -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Pesanan Terbaru</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left table-auto">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-gray-500">No</th>
                                <th class="px-4 py-2 text-gray-500">Nama Pelanggan</th>
                                <th class="px-4 py-2 text-gray-500">Produk</th>
                                <th class="px-4 py-2 text-gray-500">Tanggal</th>
                                <th class="px-4 py-2 text-gray-500">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">1</td>
                                <td class="px-4 py-2">Budi Santoso</td>
                                <td class="px-4 py-2">Brosur</td>
                                <td class="px-4 py-2">30 Jan 2026</td>
                                <td class="px-4 py-2"><span class="text-green-600 font-semibold">Selesai</span></td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">2</td>
                                <td class="px-4 py-2">Siti Aminah</td>
                                <td class="px-4 py-2">Kartu Nama</td>
                                <td class="px-4 py-2">30 Jan 2026</td>
                                <td class="px-4 py-2"><span class="text-yellow-600 font-semibold">Proses</span></td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">3</td>
                                <td class="px-4 py-2">Ahmad Fauzi</td>
                                <td class="px-4 py-2">Poster</td>
                                <td class="px-4 py-2">29 Jan 2026</td>
                                <td class="px-4 py-2"><span class="text-red-600 font-semibold">Revisi</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>
