<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\OperatorEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OperatorEventController extends Controller
{
    // Menampilkan daftar event
    public function index()
    {
        $operator_events = OperatorEvent::latest()->get();
        return view('Operator.OperatorEvent.index', compact('operator_events'));
    }

    // Form tambah event
    public function create()
    {
        return view('Operator.OperatorEvent.create');
    }

    // Simpan event baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto_event' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->only(['nama_event', 'deskripsi']);
            $data['created_by'] = Auth::check() ? Auth::user()->name : 'System';

            if ($request->hasFile('foto_event')) {
                $data['foto_event'] = $request->file('foto_event')->store('foto_event', 'public');
            }

            OperatorEvent::create($data);
            DB::commit();

            return redirect()->route('operator_event.index')->with('success', 'Event berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Gagal menyimpan event: ' . $e->getMessage())->withInput();
        }
    }

    // Form edit event
    public function edit($id)
    {
        $event = OperatorEvent::findOrFail($id);
        return view('Operator.OperatorEvent.edit', compact('event'));
    }

    // Update event
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto_event' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $event = OperatorEvent::findOrFail($id);
            $data = $request->only(['nama_event', 'deskripsi']);
            $data['updated_by'] = Auth::check() ? Auth::user()->name : 'System';

            if ($request->hasFile('foto_event')) {
                // Hapus foto lama jika ada
                if ($event->foto_event && Storage::disk('public')->exists($event->foto_event)) {
                    Storage::disk('public')->delete($event->foto_event);
                }

                $data['foto_event'] = $request->file('foto_event')->store('foto_event', 'public');
            }

            $event->update($data);
            DB::commit();

            return redirect()->route('operator_event.index')->with('success', 'Event berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Gagal memperbarui event: ' . $e->getMessage())->withInput();
        }
    }

    // Hapus event
    public function destroy($id)
    {
        $event = OperatorEvent::findOrFail($id);

        // Hapus file foto jika ada
        if ($event->foto_event && Storage::disk('public')->exists($event->foto_event)) {
            Storage::disk('public')->delete($event->foto_event);
        }

        $event->delete();
        return redirect()->route('operator_event.index')->with('success', 'Event berhasil dihapus.');
    }
}
