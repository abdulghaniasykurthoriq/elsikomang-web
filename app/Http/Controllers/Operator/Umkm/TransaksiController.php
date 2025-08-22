<?php

namespace App\Http\Controllers\Operator\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index()
    {
        return view('Operator.umkm.Transaksi.index');
    }

    public function data(Request $request)
    {
        $data = Transaksi::with(['user', 'transaksiDetail']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('order_id', fn($row) => $row->order_id)
            ->addColumn('user', fn($row) => $row->user?->name ?? '-')
            ->addColumn('amount', fn($row) => 'Rp' . number_format($row->amount, 0, ',', '.'))
            ->addColumn('total_ongkos', fn($row) => 'Rp' . number_format($row->total_ongkos, 0, ',', '.'))
            ->addColumn('payment_method', fn($row) => $row->payment_method ?? '-')
            ->addColumn('status', fn($row) => '<span class="px-2 py-1 rounded bg-' .
    ($row->status === 'received' ? 'blue' :
    ($row->status === 'shipping' ? 'yellow' :
    ($row->status === 'done' ? 'green' :
    ($row->status === 'failed' ? 'red' : 'gray')))) .
    '-500 text-white text-xs">' . ucfirst($row->status) . '</span>')
            ->addColumn('action', function ($row) {
                if ($row->status === 'failed') {
                    return '<form method="POST" action="' . route('transaksi.destroy', $row->id) . '" onsubmit="return confirm(\'Yakin hapus transaksi ini?\')">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button class="btn btn-sm bg-red-600 text-white hover:bg-red-700">Hapus</button>
                            </form>';
                } elseif (in_array($row->status, ['success', 'shipping'])) {
                    $label = $row->status === 'success' ? 'Kirim' : 'Edit Resi';
                    $bglabel = $row->status === 'success' ? 'blue' : 'gray';
                    return '<button 
                        onclick="openEditModal('
                            . $row->id . ', '
                            . '\'' . $row->status . '\', '
                            . '\'' . ($row->no_resi ?? '') . '\', '
                            . '\'' . ($row->kurir ?? '') . '\', '
                            . '\'' . ($row->kurir_service ?? '') . '\')"
                        class="btn btn-sm bg-' . $bglabel . '-500 text-white hover:bg-' . $bglabel . '-600">'
                . $label . '</button>';
                } else {
                    return '-';
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }



    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:shipping',
            'no_resi' => 'nullable|string|max:100',
        ]);

        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status === 'shipping') {
            // Hanya boleh update no_resi
            $transaksi->no_resi = $request->no_resi;
        } else {
            // Boleh update status dan no_resi
            if ($request->status) {
                $transaksi->status = $request->status;
            }
            $transaksi->no_resi = $request->no_resi;
        }

        $transaksi->save();

        return response()->json(['message' => 'Transaksi berhasil diperbarui.']);
    }


    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        if ($transaksi->status !== 'failed') {
            return response()->json(['message' => 'Transaksi hanya bisa dihapus jika statusnya gagal.'], 403);
        }

        $transaksi->delete();
        return response()->json(['message' => 'Transaksi berhasil dihapus.']);
    }
}
