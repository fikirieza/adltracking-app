@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Dashboard Driver</h2>
    <p>Halo {{ auth()->user()->name }}! Ini adalah dashboard sopir.</p>

    <div class="card text-bg-primary mb-3" style="width: 18rem;">
        <div class="card-header"><strong>Pekerjaan untukmu</strong></div>
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
            <p class="card-text">Cek surat jalan untuk pekerjaanmu</p>
            <a href="{{ route('driver.shipments.index') }}" class="btn btn-light text-primary">Cek disini</a>
        </div>
    </div>
</div>
@endsection