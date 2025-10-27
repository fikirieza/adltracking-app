@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Detail Surat Jalan</h3>
    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>No. Surat:</strong> {{ $shipment->delivery_number }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($shipment->delivery_date)->format('d/m/Y') }}</p>
            <p><strong>Penerima:</strong> {{ $shipment->receiver }}</p>
            <p><strong>Tujuan:</strong> {{ $shipment->destination }}</p>
            <p><strong>Barang:</strong></p>
            <ul>
                @foreach($shipment->items as $item)
                    <li>{{ $item->item_name }} - {{ $item->quantity }} {{ $item->unit }}</li>
                @endforeach
            </ul>
            <p><strong>Dibuat Oleh:</strong> {{ $shipment->admin?->name ?? '-' }}</p>
            <p><strong>Terakhir Diubah Oleh:</strong> {{ $shipment?->editor->name ?? '-' }}</p>

            <a href="{{ route('driver.shipments.index') }}" class="btn btn-secondary mt-3">Kembali</a>
            <a href="{{ route('driver.shipments.pdf', $shipment->id) }}" class="btn btn-primary mt-3">Download PDF</a>
        </div>
    </div>
</div>
@endsection
