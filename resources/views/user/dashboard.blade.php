<!DOCTYPE html>
<html>
<head>
    <title>Dashboard User</title>
</head>
<body>

    <h1>Dashboard User</h1>
    <p>Halo, <strong>{{ auth()->user()->name }}</strong></p>

    <hr>

    <h3>Menu User</h3>
    <ul>
        <li><a href="#">Lihat Katalog Produk</a></li>
        <li><a href="{{ route('criteria-weights.create') }}">Input Bobot Kriteria</a></li>
        <li><a href="#">Lihat Rekomendasi Produk (TOPSIS)</a></li>
        <li><a href="#">Keranjang Belanja</a></li>
        <li><a href="#">Riwayat Transaksi</a></li>
    </ul>

    <hr>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>
</html>
