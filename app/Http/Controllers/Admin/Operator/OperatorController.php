<?php

namespace App\Http\Controllers\Admin\Operator;

use App\Models\User;
use App\Models\JenisOperator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

        return view('Admin.Operator.create', compact('jenisOperator', 'role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users',
            'role'  => 'required'
        ]);

        DB::beginTransaction();
        try {
            $passwordRandom = Str::random(8);

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($passwordRandom),
                'role'     => 'Operator ' . $request->role,
            ]);

            // Kirim email ke operator
            Mail::send('emails.operator_account_created', [
                'name'     => $user->name,
                'email'    => $user->email,
                'password' => $passwordRandom,
                'role'     => $request->role
            ], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Akun Operator Anda Telah Dibuat');
            });

            DB::commit();
            return redirect()->route('operator.index', ['role' => $request->role])
                ->with('success', 'Operator berhasil ditambahkan. Password telah dikirim ke email operator.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal menambahkan operator: ' . $th->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $jenisOperator = JenisOperator::all();
        $role = $request->get('role');
        return view('Admin.Operator.edit', compact('jenisOperator', 'user', 'role'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required',
        ]);

        DB::beginTransaction();
        try {
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
                'role'  => 'Operator ' . $request->role,
            ]);

            DB::commit();
            return redirect()->route('operator.index', ['role' => $request->role])
                ->with('success', 'Operator berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal memperbarui operator: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            User::findOrFail($id)->delete();

            DB::commit();
            return redirect()->route('operator.index')->with('success', 'Operator berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal menghapus operator: ' . $th->getMessage());
        }
    }
}
