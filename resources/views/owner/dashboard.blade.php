<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Owner</title>
</head>
<body>

    <h1>Dashboard Owner</h1>
    <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong></p>

    <hr>

    <h3>Ringkasan Sistem</h3>
    <ul>
        <li>Total Transaksi: <strong>(akan dihitung sistem)</strong></li>
        <li>Total Pendapatan: <strong>(akan dihitung sistem)</strong></li>
        <li>Produk Terbaik (TOPSIS): <strong>(hasil SPK)</strong></li>
    </ul>

    <hr>

    <h3>Akses Owner</h3>
    <ul>
        <li><a href="#">Lihat Laporan Penjualan</a></li>
        <li><a href="#">Lihat Hasil SPK TOPSIS</a></li>
        <li><a href="#">Riwayat Transaksi</a></li>
    </ul>

    <p><em>*Owner hanya bersifat monitoring dan tidak dapat mengubah data.</em></p>

    <hr>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>
</html>
