<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Surat Jalan - {{ $shipment->delivery_number ?? 'Tanpa Nomor' }}</title>
    <style>
        /* PAGE */
        @page {
            size: A4;
            margin: 12mm; /* kecilkan agar area cetak lebih aman pada beberapa printer */
        }

        /* RESET & LAYOUT */
        * { box-sizing: border-box; }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            color: #000;
            background: #fff;
            -webkit-print-color-adjust: exact;
        }

        /* Container disesuaikan agar tidak melebar melebihi area printable */
        .container {
            width: 100%;
            max-width: 210mm; /* lebar A4 */
            padding: 12mm;     /* mencerminkan @page margin */
            margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            line-height: 1.15;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #000;
            width: 89%;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .header-left { width: 100%; }
        .header-left h3 { margin: 0; font-size: 18px; }
        .header-left p { margin: 2px 0; }
        .header-right { text-align: right; width: 60%; }
        .title { font-size: 20px; text-decoration: underline; margin: 0; }

        /* Info rows (no border table) */
        .info { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .info td { vertical-align: top; padding: 4px; }

        /* Main table styling */
        table.items {
            width: 89%;
            border-collapse: collapse;
            margin-top: 8px;
            table-layout: auto;
            word-wrap: break-word;
        }
        table.items th, table.items td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }
        table.items th { background: #f1f1f1; font-weight: 700; }

        /* Force thead to repeat on each printed page */
        thead { display: table-header-group; }
        tfoot { display: table-footer-group; }

        /* Hindari pemecahan antar baris */
        tr { page-break-inside: avoid; }

        /* Footer / signature */
        .note { margin-top: 10px; font-size: 12px; }
        .footer {
            margin-top: 16px;
            font-size: 12px;
        }
        .footer-sign {
            display: flex;
            justify-content: flex-end; /* bagi rata kiri - tengah - kanan */
            text-align: center;
            width: 100%;
        }

        .footer-sign div {
            flex: 1;               /* masing-masing ambil 1/3 dari lebar container */
            padding: 0 10px;       /* biar gak nempel ke border */
        }

        .footer-sign div .line {
            margin-top: 70px;      /* jarak antara label dan garis tanda tangan */
        }

        /* Print-specific tweaks */
        @media print {
            html, body { background: #fff; }
            .container { padding: 0; margin: 0; }
            /* Jika browser memberi margin print sendiri, biarkan; jangan paksa overflow */
            a { color: #000; text-decoration: none; }
        }

        /* Small helpers */
        .right { text-align: right; }
        .bold { font-weight: 700; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <table>
                    <tr>
                        <td>
                            <img src="{{ public_path('images/base-adl.jpg') }}" alt="" style="width:100px; height:100px; margin-top: 10px;">
                        </td>
                        <td>
                            <h3>PT. Anugrah Dwijaya Logistics</h3>
                            <p>Jl. Pasirmalang No.31, Baleendah - Kabupaten Bandung 40375</p>
                            <p>Telp/Fax. (022) 8593 6466 / 0852 5454 5373</p>
                            <p>Email: ptanugrahdwijaya@gmail.com</p>
                        </td>
                        <td>
                            <img src="{{ public_path('images/base-subadl.jpg') }}" alt="" style="width:100px; height:100px; margin-left: 130px;">
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            <br>
            <div class="header-right">
                <p class="title">SURAT JALAN</p>
            </div>
        </div>

        <table class="info">
            <tr>
                <td><strong>Kepada Yth.</strong></td>
            </tr>
            <tr>
                <td style="width:55%;">
                    <strong>Penerima:</strong><br>{{ $shipment->receiver ?? '-' }}<br>
                    <strong>Alamat:</strong><br>{{ $shipment->destination ?? '-' }}<br>
                </td>
                <td style="width:30%;">
                    <strong>No. Invoice:</strong> {{ $shipment->delivery_number }}<br>
                    <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($shipment->delivery_date)->format('d/m/Y') }}<br>
                </td>
            </tr>
        </table>

        <table class="items" role="table" aria-label="Daftar Barang">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shipment->items as $item)
                <tr>
                    <td>{{ $item->item_name }}</td>
                    <td class="right">{{ $item->quantity }}</td>
                    <td>{{ $item->unit }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="note">
            <strong>Catatan:</strong>
            <div style="height: 50px;">

            </div>
            <strong>PERHATIAN:</strong><br>
            1. Surat Jalan ini merupakan bukti resmi penerimaan barang<br>
            2. Surat Jalan ini bukan bukti penjualan<br>
            3. Surat Jalan ini akan dilengkapi invoice sebagai bukti penjualan
        </div>

        <div class="footer">
            <p><strong>BARANG SUDAH DITERIMA DALAM KEADAAN BAIK DAN CUKUP oleh:</strong></p>
            <div class="footer-sign">
                <table style="width: 100%; text-align: center; border-collapse: collapse;">
                    <tr>
                        <td style="width: 33.33%;">
                            <p style="margin-left:-100px;">Penerima / Pembeli</p>
                            <div style="margin-left:-100px; margin-top: 70px;">______________________</div>
                            <p style="margin-left:-100px;">&nbsp;</p>
                        </td>
                        <td style="width: 33.33%;">
                            <p style="margin-left:-100px;">Driver</p>
                            <div style="margin-left:-100px; margin-top: 70px;">______________________</div>
                            <p style="margin-left:-100px;">{{ $shipment->driver->name }}</p>
                        </td>
                        <td style="width: 33.33%;">
                            <p style="margin-left:-100px;">Direktur</p>
                            <img src="{{ public_path('images/join-es.jpg') }}" alt="" style="width:100px; height:60px; margin-left:-100px;">
                            <div style="margin-left:-100px;">______________________</div>
                            <p style="margin-left:-100px;">Iwan Setiawan</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Uncomment untuk auto-print saat membuka --}}
    {{-- <script>window.print();</script> --}}
</body>
</html>
