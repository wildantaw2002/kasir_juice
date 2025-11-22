<?php

namespace App\Http\Controllers;

use App\Models\t_menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class menu_controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = t_menu::query();

        // Search
        if ($request->has('search')) {
            $query->where('nama_menu', 'like', '%' . $request->search . '%')
                  ->orWhere('id_menu', 'like', '%' . $request->search . '%');
        }

        // Filter by kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $menus = $query->latest()->paginate(10);
        $kategoris = t_menu::distinct()->pluck('kategori');

        return view('menu.index', compact('menus', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_menu' => 'required|string|max:255|unique:t_menu,id_menu',
            'nama_menu' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('menu-photos', 'public');
        }

        t_menu::create($validated);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu = t_menu::findOrFail($id);
        return view('menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = t_menu::findOrFail($id);
        return view('menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = t_menu::findOrFail($id);

        $validated = $request->validate([
            'id_menu' => 'required|string|max:255|unique:t_menu,id_menu,' . $id,
            'nama_menu' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto
            if ($menu->foto) {
                Storage::disk('public')->delete($menu->foto);
            }
            $validated['foto'] = $request->file('foto')->store('menu-photos', 'public');
        }

        $menu->update($validated);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = t_menu::findOrFail($id);

        // Delete foto
        if ($menu->foto) {
            Storage::disk('public')->delete($menu->foto);
        }

        $menu->delete();

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil dihapus!');
    }
}
