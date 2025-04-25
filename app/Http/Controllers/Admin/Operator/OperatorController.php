<?php

namespace App\Http\Controllers\Admin\Operator;

use App\Models\Operator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JenisOperator;
use App\Models\User;
use Illuminate\Support\Str;


class OperatorController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role');

    
        if ($role) {
        $operators = User::where('role', 'Operator ' . ucfirst($role))->get();
        } else {
            $operators = User::all();
        }


        return view('Admin.Operator.index', compact('operators', 'role'));
    }

    public function create(Request $request)
    {

        $jenisOperator = JenisOperator::all();
        $role = $request->get('role');
        $role == 'box-office' ? $role= 'Box Office': $role;
        return view('Admin.Operator.create', compact('jenisOperator', 'role'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required'
        ]);
        // $passwordRandom = Str::random(8); // generate password acak 8 karakter

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            // 'password' => bcrypt( $passwordRandom),// pakai input kalau ada, atau password random
            'password' => bcrypt( $request->password), 
            'role' => 'Operator ' . $request->role,
        ]);
        return redirect()->route('operator.index', ['role' => $request->role])
                ->with('success', 'Operator berhasil ditambahkan.');
    }

    public function edit(Request $request,$id)
    {
        // dd('jjj');
        $user = User::findOrFail($id);
        $jenisOperator = JenisOperator::all();
        $role = $request->get('role');
        $role == 'box-office' ? $role= 'Box Office': $role;
        return view('Admin.Operator.edit', compact('jenisOperator','user', 'role'));
    }
    
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required',
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => 'Operator ' . $request->role, // tambahkan prefix "Operator"
    ]);
    return redirect()->route('operator.index', ['role' => $request->role])
        ->with('success', 'Operator berhasil diperbarui.');
}


    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('operator.index')->with('success', 'Operator berhasil dihapus.');
    }
}