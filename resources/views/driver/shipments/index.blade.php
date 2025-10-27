@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h3>Surat Jalan Saya</h3>
    <table id="driverShipmentsTable" class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Surat</th>
                <th>Tanggal</th>
                <th>Tujuan</th>
                <th>Penerima</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shipments as $shipment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $shipment->delivery_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($shipment->delivery_date)->format('d/m/Y') }}</td>
                    <td>{{ $shipment->destination }}</td>
                    <td>{{ $shipment->receiver }}</td>
                    <td>
                        <a href="{{ route('driver.shipments.show', $shipment->id) }}" class="btn btn-info btn-md text-light">Detail</a>
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
    let table = new DataTable('#driverShipmentsTable', {
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        pageLength: 10,
        language: {
            emptyTable: "Tidak ada data yang ditemukan",
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
