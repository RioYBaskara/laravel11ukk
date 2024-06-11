<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class KategoriController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     */
    public function getDeskripsiKategori($kode)
    {
        $kategoriMap = [
            'M' => 'Modal',
            'A' => 'Alat',
            'BHP' => 'Bahan Habis Pakai',
            'BTHP' => 'Bahan Tidak Habis Pakai',
        ];
    
        return $kategoriMap[$kode] ?? $kode;
    }
    
    public function index()
    {
        // Fetch all Kategori records
        $rsetKategori = Kategori::all()->map(function ($item) {
            $item->kategori = $this->getDeskripsiKategori($item->kategori);
            return $item;
        });
    
        // Return the index view with the Kategori data
        return view('v_latihan.index', compact('rsetKategori'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create form view
        return view('v_latihan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $this->validate($request, [
            'deskripsi' => 'required|string|max:100',
            'kategori' => 'required|in:M,A,BHP,BTHP',
        ]);        

        // Create a new Kategori record
        Kategori::create($validatedData);

        // Redirect to the index page with a success message
        return redirect()->route('kategori.index')->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Fetch the Kategori record with the specified ID
        $rsetKategori = Kategori::find($id);

        // Return the show view with the Kategori data
        return view('v_latihan.show', compact('rsetKategori'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Fetch the Kategori record with the specified ID
        $rsetKategori = Kategori::find($id);

        // Return the edit form view with the Kategori data
        return view('v_latihan.edit', compact('rsetKategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $this->validate($request, [
            'deskripsi' => 'required|string|max:100',
            'kategori' => 'required|in:M,A,BHP,BTHP',
        ]);        

        // Fetch the Kategori record with the specified ID
        $rsetKategori = Kategori::find($id);

        // Update the Kategori record
        $rsetKategori->update($validatedData);

        // Redirect to the index page with a success message
        return redirect()->route('kategori.index')->with('success', 'Data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (DB::table('barang')->where('kategori_id', $id)->exists()){
            return redirect()->route('kategori.index')->with(['Gagal' => 'Data Gagal Dihapus!']);
        } else {
            $rsetKategori = Kategori::find($id);
            $rsetKategori->delete();
            return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }    
    }
}
