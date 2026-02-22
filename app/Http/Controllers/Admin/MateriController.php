<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    // Tambahkan Request $request di dalam kurung
    public function index(Request $request)
    {
        $materis = Materi::query()
            // Jika ada input 'search', maka jalankan query pencarian
            ->when($request->search, function($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        return view('admin.materi.index', compact('materis'));
    }
    public function create()
    {
        return view('admin.materi.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'content'     => 'required|string',
        'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'is_active'   => 'nullable|boolean'
    ]);

    $thumbnailPath = null;
    if ($request->hasFile('thumbnail')) {
        $thumbnailPath = $request->file('thumbnail')->store('materi', 'public');
    }

    // MENGGUNAKAN updateOrCreate: Jika judul & deskripsi sama, jangan buat baru, tapi update saja.
    // Ini mencegah data double jika user klik simpan 2x.
    Materi::updateOrCreate(
        [
            'title' => $request->title,
            'description' => $request->description,
        ],
        [
            'content'     => $request->content,
            'thumbnail'   => $thumbnailPath,
            'is_active'   => $request->is_active ?? true,
        ]
    );

    return redirect()->route('admin.materis.index')->with('success', 'Materi berhasil diproses');
}

    public function show(string $id)
    {
        $materi = Materi::findOrFail($id);
        return view('admin.materi.show', compact('materi'));
    }

    public function edit(string $id)
    {
        $materi = Materi::findOrFail($id);
        return view('admin.materi.edit', compact('materi'));
    }

    public function update(Request $request, string $id)
    {
        $materi = Materi::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'content'     => 'required|string',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'   => 'nullable|boolean'
        ]);

        $thumbnailPath = $materi->thumbnail;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')
                                     ->store('materi', 'public');
        }

        $materi->update([
            'title'       => $request->title,
            'description' => $request->description,
            'content'     => $request->content,
            'thumbnail'   => $thumbnailPath,
            'is_active'   => $request->is_active ?? false,
        ]);

        return redirect()->route('admin.materis.index')
                         ->with('success', 'Materi berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $materi = Materi::findOrFail($id);
        $materi->delete();

        return redirect()->route('admin.materis.index')
                         ->with('success', 'Materi berhasil dihapus');
    }
}
