<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Pastikan user adalah operator
        if (!$user || !str_starts_with(strtolower($user->role), 'operator')) {
            abort(403, 'Unauthorized: Bukan operator');
        }

        // Pastikan user punya jenis operator
        if (!$user->jenisOperator || !$user->jenisOperator->url_parameter) {
            abort(403, 'Unauthorized: Jenis operator tidak ditemukan');
        }

        // Cocokkan parameter {jenis} dari URL dengan milik user
        $jenisFromUrl = strtolower($request->route('jenis'));
        $jenisFromUser = strtolower($user->jenisOperator->url_parameter);

        if ($jenisFromUrl !== $jenisFromUser) {
            abort(403, 'Unauthorized: Akses jenis operator tidak sesuai');
        }

        return $next($request);
    }
}
 