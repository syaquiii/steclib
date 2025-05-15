<?php

namespace App\Http\Controllers;

use App\Models\Penerbit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenerbitController extends Controller
{
    /**
     * Display a listing of the publishers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penerbits = Penerbit::all();
        return view('penerbits.index', compact('penerbits'));
    }

    /**
     * Show the form for creating a new publisher.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penerbits.create');
    }

    /**
     * Store a newly created publisher in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|unique:penerbits',
            'nama' => 'required|string|max:45',
            'alamat' => 'required|string|max:60',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Penerbit::create($request->all());

        return redirect()->route('penerbits.index')
            ->with('success', 'Publisher created successfully.');
    }

    /**
     * Display the specified publisher.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penerbit = Penerbit::findOrFail($id);
        return view('penerbits.show', compact('penerbit'));
    }

    /**
     * Show the form for editing the specified publisher.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $penerbit = Penerbit::findOrFail($id);
        return view('penerbits.edit', compact('penerbit'));
    }

    /**
     * Update the specified publisher in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $penerbit = Penerbit::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:45',
            'alamat' => 'required|string|max:60',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $penerbit->update($request->all());

        return redirect()->route('penerbits.index')
            ->with('success', 'Publisher updated successfully.');
    }

    /**
     * Remove the specified publisher from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penerbit = Penerbit::findOrFail($id);

        // Check if the publisher has associated books
        if ($penerbit->bukus()->count() > 0) {
            return redirect()->route('penerbits.index')
                ->with('error', 'Cannot delete publisher. It has associated books.');
        }

        $penerbit->delete();

        return redirect()->route('penerbits.index')
            ->with('success', 'Publisher deleted successfully.');
    }

    /**
     * Display books from this publisher.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function books($id)
    {
        $penerbit = Penerbit::findOrFail($id);
        $books = $penerbit->bukus;

        return view('penerbits.books', compact('penerbit', 'books'));
    }
}