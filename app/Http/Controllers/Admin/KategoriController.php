<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriLayanan;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()){
            $query = KategoriLayanan::query();

            return datatables()->of($query)
            ->addIndexColumn()
            ->editColumn('action', function($item) {
                return '
                    <a href="' . route('kategori.edit', $item->id) . '" class="btn btn-primary">
                        Edit
                    </a>
                    <form action="' . route('kategori.destroy', $item->id) . '" method="POST" class="d-inline">
                        ' . method_field('delete') . csrf_field() . '
                        <button class="btn btn-danger">
                            Hapus
                        </button>
                    </form>
                ';
            })
            ->rawColumns([])
            ->make(true);
        }

        return view('pages.admin.kategori.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $kategori = KategoriLayanan::create($data);
        if ($kategori){ 
            Alert::success('Berhasil', 'Data BERHASIL Disimpan');
            return redirect()->route('kategori.index');            
        } else {
            Alert::success('Berhasil', 'Data GAGAL Disimpan');
            return redirect()->route('kategori.create');
        }

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
        $item = KategoriLayanan::findOrFail($id);

        return view('pages.admin.kategori.edit', [
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $item = KategoriLayanan::findOrFail($id);

        
        if ($item->update($data)){
            Alert::success('Berhasil', 'Data BERHASIL Diubah');
            return redirect()->route('kategori.index');
        }else {
            Alert::success('Berhasil', 'Data GAGAL Diubah');
            return redirect()->route('kategori.edit', $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $item = KategoriLayanan::findOrFail($id);

        if($item->delete()){
            Alert::success('Berhasil', 'Data BERHASIL Dihapus');
            return redirect()->route('kategori.index');
        }else {
            Alert::success('Berhasil', 'Data GAGAL Dihapus');
            return redirect()->route('kategori.index');
        }
    }
}
