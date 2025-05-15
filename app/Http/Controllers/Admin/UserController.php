<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoverMenu;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('Admin.User.index');
    }

    public function data(Request $request)
    {
        $data = User::where('role', 'User'); // Menambahkan filter hanya user dengan role 'User'

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('foto', function ($row) {
                $url = asset('storage/' . $row->foto);
                return '<img src="' . $url . '" width="50">';
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('cover-menu.edit', $row->id) . '" class="btn btn-sm bg-yellow-500 text-white hover:bg-yellow-600 focus:ring focus:ring-yellow-300">Edit</a>';
            })
            ->rawColumns(['foto', 'action'])
            ->make(true);

            }
}
