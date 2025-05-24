<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $penerbits = Penerbit::where('nama', 'LIKE', "%{$search}%")
            ->orWhere('alamat', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('admin.penerbit.index', compact('penerbits', 'search', ));
    }

    public function create()
    {
        return view('admin.penerbit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        Penerbit::create($request->only(['nama', 'alamat']));

        return redirect()->route('admin.penerbit.index')->with('success', 'Penerbit berhasil ditambahkan.');
    }

    public function edit(Penerbit $penerbit)
    {
        return view('admin.penerbit.edit', compact('penerbit'));
    }

    public function update(Request $request, Penerbit $penerbit)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $penerbit->update($request->only(['nama', 'alamat']));

        return redirect()->route('admin.penerbit.index')->with('success', 'Penerbit berhasil diperbarui.');
    }

    public function destroy(Penerbit $penerbit)
    {
        $penerbit->delete();

        return redirect()->route('admin.penerbit.index')->with('success', "Penerbit {$penerbit->nama} berhasil dihapus.");
    }
}