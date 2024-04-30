<?php

namespace App\Http\Controllers;

use App\Models\DnpgFile;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class DnpgFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DnpgFile::with(['images' => function ($query) {
                $query->select('id', 'image_id', 'keterangan', 'image_name', 'url');
            }])->with('user');
            return DataTables::of($query)->toJson();
        }
        return view('dnpg.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dnpg.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:16048', // Menerima multiple files
            'dnpgno' => 'required',
            // 'keterangan.*' => 'required', // Validasi keterangan untuk setiap file
        ]);

        try {
            // Memulai transaksi database
            DB::beginTransaction();

            $uuid = Str::uuid();
            // Simpan data ke database dalam transaksi
            $insertDB_dnpg = DnpgFile::create([
                'id' => Str::uuid(),
                'user_id' => Auth::id(),
                'dnpg_no' => $request->dnpgno,
                'created_at' => now(),
            ]);
            $dnpgFileId = $insertDB_dnpg->id;

            // Loop melalui setiap file yang dikirimkan
            foreach ($request->file('files') as $index => $file) {
                // Proses file yang diunggah
                if ($file->isValid()) {
                    $destinationPath = 'uploads';
                    $uuid = Str::uuid();
                    $fileName = $uuid . '.' . $file->getClientOriginalExtension();
                    $path = $file->move($destinationPath, $fileName);

                    // Membuat URL gambar
                    $imageUrl = url($destinationPath . '/' . $fileName);

                    $insertDB_Image = Images::create([
                        'id' => $uuid,
                        'image_id' => $dnpgFileId,
                        'keterangan' => $request->keterangan[$index], // Ambil keterangan sesuai dengan index
                        'image_name' => $fileName,
                        'url' => $imageUrl,
                        'created_at' => now()
                    ]);
                } else {
                    // Jika file tidak valid, tangani sesuai kebutuhan
                    DB::rollback();
                    return response()->json(['error' => 422, 'message' => 'File tidak valid'], 422);
                }
            }

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            // Respon ke frontend
            return response()->json(['message' => 'Files uploaded successfully'], 201);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            // Rollback transaksi untuk mengembalikan database ke keadaan semula
            DB::rollback();

            // Respon atau tanggapi kesalahan sesuai kebutuhan
            return response()->json(['error' => 500, 'message' => $e], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DnpgFile  $dnpgFile
     * @return \Illuminate\Http\Response
     */
    public function show(DnpgFile $dnpgFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DnpgFile  $dnpgFile
     * @return \Illuminate\Http\Response
     */
    public function edit(DnpgFile $dnpgFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DnpgFile  $dnpgFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DnpgFile $dnpgFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DnpgFile  $dnpgFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(DnpgFile $dnpgFile)
    {
        //
    }
}
