<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SplashScreen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SplashScreenController extends Controller
{
    public function index()
    {
        $splashscreens = SplashScreen::all();
        return view('Admin.SplashScreen.index', compact('splashscreens'));
    }
    public function create()
    {
        return view('Admin.SplashScreen.create');
        
    }
    public function store(Request $request)
    {
        $request->validate([
            'image_content' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_footer'  => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $data = [];
    
        if ($request->hasFile('image_content')) {
            $data['image_content'] = $request->file('image_content')->store('splashscreen', 'public');
        }
    
        if ($request->hasFile('image_footer')) {
            $data['image_footer'] = $request->file('image_footer')->store('splashscreen', 'public');
        }
    
        SplashScreen::create($data);
    
        return redirect()->route('splashscreen.index')->with('success', 'Splash screen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $splashscreen = SplashScreen::find($id);
        if (!$splashscreen) {
            return redirect()->route('splashscreen.index')->with('error', 'Splash screen tidak ditemukan.');
        }

        return view('Admin.SplashScreen.edit',compact('splashscreen'));
        
    }

  
    public function update(Request $request, string $id)
    {
        $splashscreen = SplashScreen::find($id);
        if (!$splashscreen) {
            return redirect()->route('splashscreen.index')->with('error', 'Splash screen tidak ditemukan.');
        }

        $request->validate([
            'image_content' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_footer'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [];

        if ($request->hasFile('image_content')) {
            // Hapus file lama jika ada
            if ($splashscreen->image_content && file_exists(storage_path('app/public/' . $splashscreen->image_content))) {
                Storage::disk('public')->delete($splashscreen->image_content);
            }
            $data['image_content'] = $request->file('image_content')->store('splashscreen', 'public');
        }

        if ($request->hasFile('image_footer')) {
            // Hapus file lama jika ada
            if ($splashscreen->image_footer && file_exists(storage_path('app/public/' . $splashscreen->image_footer))) {
                Storage::disk('public')->delete($splashscreen->image_footer);

            }
            $data['image_footer'] = $request->file('image_footer')->store('splashscreen', 'public');
        }

        $splashscreen->update($data);

        return redirect()->route('splashscreen.index')->with('success', 'Splash screen berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
