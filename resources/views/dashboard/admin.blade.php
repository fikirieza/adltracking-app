@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Dashboard Admin</h2>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>

    <div class="row">
        <div class="card-group">
            <div class="col">
                <div class="card text-bg-primary mb-3" style="width: 18rem;">
                    <div class="card-header"><strong>Mulai langkah awal perjalanan</strong></div>
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
                        <p class="card-text">Buat surat perjalanan kirim barang anda.</p>
                        <a href="{{ route('shipments.create') }}" class="btn btn-light text-primary">Buat Surat Jalan</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-bg-success mb-3" style="width: 18rem;">
                    <div class="card-header"><strong>Telusuri catatan perjalananmu</strong></div>
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
                        <p class="card-text">Tenang saja catatan perjalananmu tersimpan disini.</p>
                        <a href="{{ route('shipments.index') }}" class="btn btn-light text-success">Catatan Perjalanan</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-bg-warning mb-3" style="width: 18rem;">
                    <div class="card-header"><strong>Buat akun untuk driver baru</strong></div>
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
                        <p class="card-text">Ayo buatkan akun untuk mempermudah pekerjaan.</p>
                        <a href="{{route('drivers.index')}}" class="btn btn-light text-dark">Buat akun driver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection