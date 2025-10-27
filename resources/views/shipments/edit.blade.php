@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="col-md-8">
        <!-- Tombol Accordion -->
        <button type="button" class="btn btn-success w-100 mb-3" data-bs-toggle="collapse" data-bs-target="#formSuratJalan" aria-expanded="true">
            Edit Surat Jalan
        </button>

        <!-- tambahkan class show biar langsung kebuka -->
        <div class="collapse show" id="formSuratJalan">
            <div class="card shadow-sm">
                <div class="card-body">
                    {{-- ubah ke route update, dan kasih id shipment --}}
                    <form action="{{ route('shipments.update', $shipment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Info Surat Jalan -->
                        <div class="mb-3">
                            <label class="form-label">Penerima</label>
                            <input type="text" name="receiver" class="form-control"
                                value="{{ old('receiver', $shipment->receiver) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tujuan</label>
                            <input type="text" name="destination" class="form-control"
                                value="{{ old('destination', $shipment->destination) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sopir</label>
                            <select name="driver_id" class="form-control" required>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ $shipment->driver_id == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->name }} ({{ $driver->phone }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Barang Dinamis -->
                        <div id="items-wrapper">
                            @forelse($shipment->items as $index => $item)
                                <div class="row mb-2 item-row">
                                    <div class="col">
                                        <input type="text" name="items[{{ $index }}][item_name]" class="form-control"
                                            placeholder="Barang"
                                            value="{{ old('items.'.$index.'.item_name', $item->item_name) }}" required>
                                    </div>
                                    <div class="col">
                                        <input type="number" name="items[{{ $index }}][quantity]" class="form-control"
                                            placeholder="Jumlah"
                                            value="{{ old('items.'.$index.'.quantity', $item->quantity) }}" required min="1">
                                    </div>
                                    <div class="col">
                                        <input type="text" name="items[{{ $index }}][unit]" class="form-control"
                                            placeholder="Satuan"
                                            value="{{ old('items.'.$index.'.unit', $item->unit) }}" required>
                                    </div>
                                    <div class="col-auto d-flex align-items-center gap-1">
                                        {{-- hanya baris terakhir yang punya tombol + --}}
                                        @if($loop->last)
                                            <button type="button" class="btn btn-success btn-add">+</button>
                                        @endif
                                        {{-- tampilkan tombol - kalau lebih dari 1 barang --}}
                                        @if($loop->count > 1)
                                            <button type="button" class="btn btn-danger btn-remove">-</button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                {{-- kalau belum ada barang, tampilkan satu baris kosong --}}
                                <div class="row mb-2 item-row">
                                    <div class="col">
                                        <input type="text" name="items[0][item_name]" class="form-control" placeholder="Barang" required>
                                    </div>
                                    <div class="col">
                                        <input type="number" name="items[0][quantity]" class="form-control" placeholder="Jumlah" required min="1">
                                    </div>
                                    <div class="col">
                                        <input type="text" name="items[0][unit]" class="form-control" placeholder="Satuan" required>
                                    </div>
                                    <div class="col-auto d-flex align-items-center">
                                        <button type="button" class="btn btn-success btn-add">+</button>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <button type="submit" class="btn btn-success w-100 mt-4">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Tambah/Hapus Barang -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    let index = {{ $shipment->items->count() ?? 1 }};
    const wrapper = document.getElementById("items-wrapper");

    wrapper.addEventListener("click", function (e) {
        // Tambah field
        if (e.target.classList.contains("btn-add")) {
            e.preventDefault();
            e.target.remove(); // hapus tombol + di baris sebelumnya

            const newRow = document.createElement("div");
            newRow.classList.add("row", "mb-2", "item-row");
            newRow.innerHTML = `
                <div class="col">
                    <input type="text" name="items[${index}][item_name]" class="form-control" placeholder="Barang" required>
                </div>
                <div class="col">
                    <input type="number" name="items[${index}][quantity]" class="form-control" placeholder="Jumlah" required min="1">
                </div>
                <div class="col">
                    <input type="text" name="items[${index}][unit]" class="form-control" placeholder="Satuan" required>
                </div>
                <div class="col-auto d-flex align-items-center gap-1">
                    <button type="button" class="btn btn-success btn-add">+</button>
                    <button type="button" class="btn btn-danger btn-remove">-</button>
                </div>
            `;
            wrapper.appendChild(newRow);
            index++;
        }

        // Hapus field
        if (e.target.classList.contains("btn-remove")) {
            e.preventDefault();
            const row = e.target.closest(".item-row");
            row.remove();

            // pastikan baris terakhir tetap ada tombol +
            const rows = wrapper.querySelectorAll(".item-row");
            if (rows.length > 0) {
                const lastActions = rows[rows.length - 1].querySelector(".col-auto");
                lastActions.innerHTML = `
                    <button type="button" class="btn btn-success btn-add">+</button>
                    ${rows.length > 1 ? '<button type="button" class="btn btn-danger btn-remove">-</button>' : ''}
                `;
            }
        }
    });
});
</script>
@endsection
