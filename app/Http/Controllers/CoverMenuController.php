<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoverMenuRequest;
use App\Models\CoverMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CoverMenuController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CoverMenu::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('foto', function ($row) {
                    $url = asset('storage/' . $row->foto);
                    return '<img src="' . $url . '" width="80">';
                })
                ->addColumn('action', function ($row) {
                    return '
                            <a href="' . route('cover-menu.edit', $row->id) . '" class="btn btn-sm bg-yellow-500 text-white hover:bg-yellow-600 focus:ring focus:ring-yellow-300">Edit</a>

                        ';
                })
                ->rawColumns(['foto', 'action'])
                ->make(true);
        }

        return view('Admin.CoverMenu.index');
    }

    // public function create()
    // {
    //     return view('Admin.CoverMenu.create');
    // }

    // public function store(CoverMenuRequest $request)
    // {
    //     $validated = $request->validated();
    //     $path = $request->file('foto')->store('cover-menu', 'public');
    //     $coverMenu = new CoverMenu();
    //     $coverMenu->nama = $validated['nama'];
    //     $coverMenu->foto = $path;
    //     $coverMenu->save();
    //     return redirect()->route('cover-menu.index')->with('success', 'Cover Menu berhasil ditambahkan.');
    // }


    public function edit($id)
    {
        $coverMenu = CoverMenu::findOrFail($id);
        return view('Admin.CoverMenu.edit', ['coverMenu' => $coverMenu]);
    }

    public function update(Request $request, CoverMenu $coverMenu)
    {

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('cover_menus', 'nama')->ignore($coverMenu->id)],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $coverMenu->nama = $validated['nama'];

        if ($request->hasFile('foto')) {
            if ($coverMenu->foto) {
                Storage::disk('public')->delete($coverMenu->foto);
            }

            $path = $request->file('foto')->store('cover-menu', 'public');
            $coverMenu->foto = $path;
        }
        $coverMenu->save();
        return redirect()->route('cover-menu.index')->with('success', 'Cover Menu berhasil diperbarui.');
    }

    // public function destroy($id)
    // {
    //     $coverMenu = CoverMenu::findOrFail($id);
    //     if ($coverMenu->foto) {
    //         Storage::disk('public')->delete($coverMenu->foto);
    //     }
    //     $coverMenu->delete();
    //     return redirect()->route('cover-menu.index')->with('success', 'Cover Menu berhasil dihapus.');
    // }       
}
