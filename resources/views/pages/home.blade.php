@extends('layouts.main')

@section('content')

    <div class="card text-justify">
        <div class="card-header p-3 ps-4">
            <h4>Tentang Aplikasi</h4>
        </div>
        <div class="card-body p-4">
            <p class="fs-4">Aplikasi ini merupakan aplikasi Data Mining yang dirancang untuk mengelompokkan siswa SMP Negeri 207 SSN berdasarkan nilai akademiknya. Metode pengelompokkan yang digunakan pada aplikasi ini adalah metode K-Means Clustering yang secara singkatnya merupakan metode yang mengelompokkan data berdasarkan karakteristiknya.</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header p-3 ps-4">
            <h4>Cara Menggunakan Aplikasi</h4>
        </div>
        <div class="card-body p-4">
            <ul class="list-group text-justify">
                <li class="list-group-item fs-5">1. Import data pada halaman "Data", pastikan file yang diinput bertipe .xlsx dan kolom header sudah sesuai dengan aplikasi.</li>
                <li class="list-group-item fs-5">2. Pilih jumlah cluster pada halaman "Pilih Cluster" kemudian klik proses.</li>
                <li class="list-group-item fs-5">3. Hasil clustering akan ditampilkan pada halaman "Hasil Clustering". User juga bisa mengexport data hasil clustering.</li>
                <li class="list-group-item fs-5">4. Untuk halaman "DBI" merupakan evaluasi dari hasil clustering. Semakin rendah nilai DBI, maka semakin akurat hasil clusteringnya.</li>
                <li class="list-group-item fs-5">5. Untuk memproses data lain, pastikan anda sudah menghapus semua data pada halaman "Data", kemudian import data baru yang ingin dilakukan klasterisasi.</li>
            </ul>
        </div>
    </div>

@endsection