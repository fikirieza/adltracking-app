<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\User;

class ShipmentController extends Controller
{
    // Tampilkan daftar surat jalan
    public function index()
    {
        $shipments = Shipment::with('driver')->latest()->get();
        return view('shipments.index', compact('shipments'));
    }
    
    // Form buat surat jalan
    public function create()
    {
        $drivers = User::where('role', 'driver')->get();
        return view('shipments.create', compact('drivers'));
    }
    
    // Simpan surat jalan baru
    public function store(Request $request)
    {
        $request->validate([
            'destination' => 'required|string',
            'receiver' => 'required|string',
            'driver_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit' => 'required|string',
        ]);

        // Generate nomor surat jalan (contoh: SJ-2025-0001)
        $last = Shipment::latest()->first();
        $nextId = $last ? $last->id + 1 : 1;
        $deliveryNumber = 'SJ-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $shipment = Shipment::create([
            'delivery_number' => $deliveryNumber,
            'delivery_date' => now(),
            'destination' => $request->destination,
            'receiver'  => $request->receiver,
            'driver_id' => $request->driver_id,
            'created_by' => auth()->id(), // admin login
            'updated_by' => auth()->id(), // belum ada yang update
        ]);

        // Simpan barang-barang
        foreach ($request->items as $item) {
            ShipmentItem::create([
                'shipment_id' => $shipment->id,
                'item_name'   => $item['item_name'],
                'quantity'    => $item['quantity'],
                'unit'        => $item['unit'],
            ]);
        }

        return redirect()->route('shipments.index')
                         ->with('success', 'Surat Jalan berhasil dibuat. Anda bisa download PDF dari daftar.');
    }

    // Detail surat jalan
    public function show(Shipment $shipment)
    {
        return view('shipments.show', compact('shipment'));
    }

    // Form edit surat jalan
    public function edit(Shipment $shipment)
    {
        $drivers = User::where('role', 'driver')->get();
        $shipment->load('items'); // Load items terkait
        return view('shipments.edit', compact('shipment', 'drivers'));
    }

    // Update surat jalan
    public function update(Request $request, Shipment $shipment)
    {
        $request->validate([
            'receiver' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'driver_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit' => 'required|string|max:50',
        ]);

        $shipment->update([
            'receiver' => $request->receiver,
            'destination' => $request->destination,
            'driver_id' => $request->driver_id,
            'updated_by' => auth()->id(),
        ]);

        //Hapus item lama dan isi ulang (cara paling aman & simpel)
        $shipment->items()->delete();

        foreach ($request->items as $item) 
            {
            $shipment->items()->create([
                'item_name' => $item['item_name'],
                'quantity'  => $item['quantity'],
                'unit'      => $item['unit'],
            ]);
            }

        return redirect()
        ->route('shipments.index')
        ->with('success', 'Surat jalan berhasil diperbarui!');
    }

    // Hapus surat jalan
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return redirect()->route('shipments.index')->with('success', 'Surat Jalan berhasil dihapus');
    }

     // Download PDF surat jalan
    public function downloadPdf(Shipment $shipment)
    {
        $driver = User::find($shipment->driver_id);
        $admin  = User::find($shipment->created_by);

        $pdf = Pdf::loadView('shipments.suratjalan', [
            'shipment' => $shipment,
            'driver' => $driver,
            'admin' => $admin,
            'items' => $shipment->items, // biar barang-barang ikut di PDF
        ]);

        return $pdf->download($shipment->delivery_number . '.pdf');
    }

}
