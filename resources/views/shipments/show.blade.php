@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Detail Surat Jalan</h2>
    
    <div class="card mt-3">
        <div class="card-body">
            <p><strong>Nomor Surat Jalan:</strong> {{ $shipment->delivery_number }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($shipment->delivery_date)->format('d/m/Y') }}</p>
            <p><strong>Penerima:</strong> {{ $shipment->receiver }}</p>
            <p><strong>Tujuan:</strong> {{ $shipment->destination }}</p>
            <p><strong>Nama Sopir:</strong> {{ $shipment->driver->name }}</p>
            <p><strong>No. HP Sopir:</strong> {{ $shipment->driver->phone }}</p>
            <p><strong>Barang:</strong></p>
            <ul>
                @foreach($shipment->items as $item)
                    <li>{{ $item->item_name }} - {{ $item->quantity }} {{ $item->unit }}</li>
                @endforeach
            </ul>
            <p><strong>Dibuat Oleh:</strong> {{ $shipment->admin?->name ?? '-' }}</p>
            <p><strong>Terakhir Diubah Oleh:</strong> {{ $shipment?->editor->name ?? '-' }}</p>

            <a href="{{ route('shipments.index') }}" class="btn btn-secondary btn-md">Kembali</a>        
            <a href="{{ route('shipments.pdf', $shipment->id) }}" class="btn btn-primary btn-md">Download PDF</a>
        </div>
    </div>

</div>
@endsection
