<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aktivasi;
use App\Http\Resources\AktivasiResource;
use Illuminate\Support\Facades\Validator;

class AktivasiController extends Controller
{
    //
    public function index()
    {
        // $aktivasi = Aktivasi::get();

        // return view('aktivasi.index', compact('aktivasi'));

        $aktivasi = Aktivasi::latest()->get();
        //render view with posts
        return new AktivasiResource(true, 'List Data Aktivasi',
        $aktivasi);
    }

    public function create()
    {
        return view('aktivasi.create');
    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            // 'nama' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $totalAktivasi = sprintf('%02d',(Aktivasi::all()->count())+1);
        $carbon=\Carbon\Carbon::now();
        $dateYY=$carbon->format('y');
        $expireddateYY=\Carbon\Carbon::now()->addYears(1);
        $dateMM=$carbon->format('m');
        $id_aktivasi=$dateYY.'.'.$dateMM.'.'.$totalAktivasi;
        //Fungsi Post ke Database
        $aktivasi = Aktivasi::create([
            'id' => $totalAktivasi,
            'id_aktivasi' => $id_aktivasi,
            'id_member' => $request->id_member,
            'nama' => $request->nama,
            'tanggal' => $carbon,
            'waktu' => $carbon,
            'masa_aktif' => $expireddateYY,
            'id_pegawai' => $request->id_pegawai,
            'nama_pegawai' => $request->nama_pegawai    
        ]);

        return new AktivasiResource(true, 'Data Aktivasi Berhasil  Ditambahkan!', $aktivasi);
        
            return redirect()->route('aktivasi.index')->with(['success'
                => 'Data Berhasil Disimpan!']);

    }

    public function show($id){
        $aktivasi = Aktivasi::find($id); //find user by id

        if (!is_null($aktivasi)) {
            return response([
                'message' => 'Retrive User Success',
                'data' => $aktivasi
            ], 200); //return user data by id
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404); //return if user by id not found 
    }
}
