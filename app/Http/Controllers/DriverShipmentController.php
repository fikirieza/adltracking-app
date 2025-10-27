<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipment;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ShipmentItem;


class DriverShipmentController extends Controller
{
     public function driverIndex()
    {
        // hanya shipment yang terkait dengan driver login
        $shipments = Shipment::where('driver_id', auth()->id())->latest()->get();

        return view('driver.shipments.index', compact('shipments'));
    }

    public function driverShow(Shipment $shipment)
    {
        // pastikan driver yang login hanya bisa akses surat jalannya sendiri
        if ($shipment->driver_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke surat jalan ini.');
        }

        return view('driver.shipments.show', compact('shipment'));
    }

    public function driverDownloadPdf(Shipment $shipment)
    {
        // pastikan driver hanya bisa download surat jalannya sendiri
        if ($shipment->driver_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $driver = auth()->user();
        $admin  = $shipment->admin; // relasi ke admin (pastikan ada relasi di model Shipment)

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('shipments.suratjalan', [
            'shipment' => $shipment,
            'driver' => $driver,
            'admin' => $admin,
            'items' => $shipment->items, // biar barang-barang ikut di PDF
        ]);

        return $pdf->download($shipment->delivery_number . '.pdf');
        }
}
