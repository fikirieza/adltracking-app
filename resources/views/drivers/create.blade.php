@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="col-md-8">
        <!-- Tombol Accordion -->
        <button type="button" class="btn btn-warning w-100 mb-3" data-bs-toggle="collapse" data-bs-target="#formAkunDriver">
            Buat Akun Driver
        </button>

        <div class="collapse" id="formAkunDriver">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('drivers.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label>No. Telepon</label>
                            <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}">
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-warning w-100 mt-4">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="container mt-4">
    <h3>Buat Akun Driver Baru</h3>
    <form action="{{ route('drivers.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label>No. Telepon</label>
            <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Simpan</button>
    </form>
</div> -->
@endsection
