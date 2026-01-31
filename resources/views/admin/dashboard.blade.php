<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
</head>
<body>

    <h1>Dashboard Admin</h1>
    <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong></p>

    <hr>

    <h3>Menu Admin</h3>
    <ul>
        <li><a href="#">Kelola Kategori Produk</a></li>
        <li><a href="#">Kelola Produk</a></li>
        <li><a href="#">Kelola Spesifikasi Produk</a></li>
        <li><a href="#">Kelola Kriteria TOPSIS</a></li>
        <li><a href="#">Lihat Data Transaksi</a></li>
    </ul>

    <hr>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>
</html>
