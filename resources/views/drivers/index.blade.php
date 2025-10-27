@extends('layouts.app')
@section('content')
<div class="container container mt-4">
    <h3>Daftar Driver</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('drivers.create') }}" class="btn btn-warning mb-3">+ Tambah Driver</a>

    <table id="driversTable" class="table table-bordered"">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($drivers as $driver)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $driver->name }}</td>
                <td>{{ $driver->email }}</td>
                <td>{{ $driver->phone }}</td>
                <td>
                    <form action="{{ route('drivers.destroy', $driver) }}" method="POST" onsubmit="return confirm('Hapus driver ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<link href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let table = new DataTable('#driversTable', {
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        pageLength: 10,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya"
            }
        }
    });
});
</script>

@endsection

