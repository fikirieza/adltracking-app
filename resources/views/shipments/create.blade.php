@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="col-md-8">
        <!-- Tombol Accordion -->
        <button type="button" class="btn btn-primary w-100 mb-3" data-bs-toggle="collapse" data-bs-target="#formSuratJalan">
            Buat Surat Jalan
        </button>

        <div class="collapse" id="formSuratJalan">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('shipments.store') }}" method="POST">
                        @csrf
                        
                        <!-- Info Surat Jalan -->
                        <div class="mb-3">
                            <label class="form-label">Penerima</label>
                            <input type="text" name="receiver" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tujuan</label>
                            <input type="text" name="destination" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sopir</label>
                            <select name="driver_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Sopir</option>   
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Barang Dinamis -->
                        <div id="items-wrapper">
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
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-4">Simpan Surat Jalan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Tambah Barang -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    let index = 1;
    const wrapper = document.getElementById("items-wrapper");

    wrapper.addEventListener("click", function (e) {
        // Tambah field
        if (e.target.classList.contains("btn-add")) {
            e.preventDefault();
            e.target.remove(); // hapus tombol + di row sebelumnya

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

            // Pastikan row terakhir ada tombol +
            const rows = wrapper.querySelectorAll(".item-row");
            if (rows.length > 0) {
                rows[rows.length - 1]
                    .querySelector(".col-auto")
                    .innerHTML = `
                        <button type="button" class="btn btn-success btn-add">+</button>
                        ${rows.length > 1 ? '<button type="button" class="btn btn-danger btn-remove">-</button>' : ''}
                    `;
            }
        }
    });
});
</script>

@endsection
