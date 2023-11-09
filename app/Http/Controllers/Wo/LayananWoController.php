<?php

namespace App\Http\Controllers\Wo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\GaleryLayanan;

class LayananWoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()){
            $query = Layanan::where('users_id', auth()->user()->id);

            return datatables()->of($query)
            ->addIndexColumn()
            ->editColumn('harga', function($item){
                return 'Rp. ' . number_format($item->harga, 0, ',', '.');
            })
            ->editColumn('thumbnail', function ($item){
                $galery = GaleryLayanan::where('layanan_id', $item->id)->first();
                return $galery ? '<img src="' . asset('storage/' . $galery->thumbnail) . '" style="max-height: 100px;">' : 'Tidak Ada Gambar';
            })
            ->editColumn('action', function($item) {
                return '
                    <a href="' . route('layanan-wo.edit', $item->id) . '" class="btn btn-primary">
                        Edit
                    </a>
                    <form action="' . route('layanan-wo.destroy', $item->id) . '" method="POST" class="d-inline">
                        ' . method_field('delete') . csrf_field() . '
                        <button class="btn btn-danger">
                            Hapus
                        </button>
                    </form>
                ';
            })
            ->rawColumns(['action', 'thumbnail'])
            ->make(true);
        }

        return view('pages.wo.layanan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.wo.layanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $item = Layanan::create([
            'nama_paket' => $request->nama_paket,
            'users_id' => Auth::user()->id,
            'slug' => Str::slug($request->nama_paket),
            'harga' => str_replace(['Rp. ', '.'], ['', ''], $request->harga),
        ]);
        if($request->hasFile('thumbnail')){
            foreach($request->file('thumbnail') as $file){
                GaleryLayanan::create([
                    'layanan_id' => $item->id,
                    'thumbnail' => $file->store('assets/layanan', 'public')
                ]);
            }
        }
    

    if($item->save()){
        Alert::success('Berhasil', 'Data BERHASIL Disimpan');
        return redirect()->route('layanan-wo.index');
    }else {
        Alert::error('Error', 'Data GAGAL Disimpan');
        return back();
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
        $item = Layanan::findOrFail($id);
        $gallery = GaleryLayanan::where('layanan_id', $id)->get();
        return view('pages.wo.layanan.edit', compact('item', 'gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Layanan::findOrFail($id);

        if($request->hasFile('thumbnail')){
            foreach($request->file('thumbnail') as $file){
                $data = new GaleryLayanan;
                $data->layanan_id = $item->id;
                $data->thumbnail = $file->store('asset/layanan', 'public');
                $data->save();
            }
        }

        $simpan = $item->update([
            'nama_paket' =>$request->nama_paket,
            'slug' => Str::slug($request->nama_paket),
            'harga' => str_replace(['Rp. ', '.'], ['', ''], $request->harga),
        ]);

        if($simpan){
            Alert::success('Berhasil', 'Data BERHASIL Disimpan');
            return redirect()->route('layanan-wo.index');
        }else {
            Alert::error('Berhasil', 'Data GAGAL Disimpan');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $layanan = Layanan::findOrFail($id);
        $galery = GaleryLayanan::where('layanan_id', $id)->get();

        //hapus data utk semua gambar yg ada
        foreach($galery as $item){
            Storage::disk('public')->delete($item->thumbnail);
            
            //hapus permanen
            $item->forceDelete(); 
        }

        //hapus layanan
        $hapusLayanan = $layanan->forceDelete();
        if($hapusLayanan){
            Alert::success('Berhasil', 'Data BERHASIL Dihapus');
            return redirect()->route('layanan-wo.index');
        }else {
            Alert::error('Berhasil', 'Data GAGAL Dihapus');
            return back();
        }
    }

    public function deleteGallery(Request $request, $id)
    {
        $item = GaleryLayanan::findOrFail($id);
        Storage::disk('public')->delete($item->thumbnail);
        $item->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Gambar Berhasil Dihapus'
        ]);
    }
}