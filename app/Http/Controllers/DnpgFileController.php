<?php

namespace App\Http\Controllers;

use App\Models\DnpgFile;
use Illuminate\Http\Request;
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
        //
        if ($request->ajax()) {
            return  DataTables::of(DnpgFile::query())->toJson();
        }
            return view('dnpg.create');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
        // Memulai transaksi database
            DB::beginTransaction();

            $request->validate([
                'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Jika validasi berhasil, lanjutkan dengan logika Anda
            if ($request->file('file')->isValid()) {
                // Proses file yang diunggah
                $destinationPath = 'uploads';
                $uuid = Str::uuid();
                $originalFileName = $request->file('file')->getClientOriginalName();
                $fileName = $uuid . '.' . $request->file('file')->getClientOriginalExtension();

                // Move the uploaded file to the specified path
                $path = $request->file('file')->move($destinationPath, $fileName);

                // untuk menjalankan sftp synology
                // $sftp = new SFTP('synology-nas-ip');
                // if (!$sftp->login('ftp-username', 'ftp-password')) {
                //     die('Login Failed');
                // }

                // $localFile = '/path/to/local/file.txt';
                // $remoteFile = '/path/on/synology/file.txt';

                // if ($sftp->put($remoteFile, $localFile, SFTP::SOURCE_LOCAL_FILE)) {
                //     echo 'File uploaded successfully.';
                // } else {
                //     echo 'Error uploading file.';
                // }
                // Simpan data ke database dalam transaksi
                $insertDB_dnpg = DnpgFile::create([
                    'uuid' => $uuid,
                    'keterangan' => $request->keterangan,
                    'image_name' => $originalFileName,
                    'url' => $path,
                    'created_at' => now(),
                ]);

                // Commit transaksi jika semua operasi berhasil
                DB::commit();

                // Respon atau redirect sesuai kebutuhan
                return response()->json(['message' => 'File uploaded successfully', 'path' => $path], 201);
            } else {
                // Jika file tidak valid, tangani sesuai kebutuhan
                return response()->json(['error' => 'File tidak valid'], 422);
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            // Rollback transaksi untuk mengembalikan database ke keadaan semula
            DB::rollback();

            // Respon atau tanggapi kesalahan sesuai kebutuhan
            return response()->json(['error' => 'Terjadi kesalahan saat mengunggah file'], 500);
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
