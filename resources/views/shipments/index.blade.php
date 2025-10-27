@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Daftar Surat Jalan</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('shipments.create') }}" class="btn btn-primary mb-3">Tambah Surat Jalan</a>
    
    <table id="shipmentsTable" class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Surat</th>
                <th>Tanggal</th>
                <th>Penerima</th>
                <th>Driver</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shipments as $shipment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $shipment->delivery_number }}</td>
                <td>{{ $shipment->delivery_date }}</td>
                <td>{{ $shipment->receiver }}</td>
                <td>{{ $shipment->driver->name ?? '-' }}</td>
                <td class="d-flex gap-2">
                    <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-info btn-md text-light">Detail</a>
                    <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-warning btn-md text-light">Edit</a>
                    <form action="{{ route('shipments.destroy', $shipment) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-md" onclick="return confirm('Yakin hapus?')">Hapus</button>
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
    let table = new DataTable('#shipmentsTable', {
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