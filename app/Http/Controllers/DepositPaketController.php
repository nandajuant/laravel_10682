<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepositPaketResource;
use App\Models\DepositPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepositPaketController extends Controller
{
    //
    public function index()
    {
        // $paket = Paket::get();

        // return view('paket.index', compact('paket'));

        $paket = DepositPaket::latest()->get();
        //render view with posts
        return new DepositPaketResource(true, 'List Data Deposit Paket',
        $paket);
    }

    public function create()
    {
        return view('deposit_pkt.create');
    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'nama' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $totalPaket = sprintf('%02d',(DepositPaket::all()->count())+1);
        $carbon=\Carbon\Carbon::now();
        $dateYY=$carbon->format('y');
        // $expireddateYY=\Carbon\Carbon::now()->addMonths(3);
        $dateMM=$carbon->format('m');
        $id_paket=$dateYY.'.'.$dateMM.'.'.$totalPaket;
        //Fungsi Post ke Database
        $paket = DepositPaket::create([
            'id' => $totalPaket,
            'id_deposit_pkt' => $id_paket,
            'id_promo' => $request->id_promo,
            'id_member' => $request->id_member,
            'nama' => $request->nama,
            'tanggal' => $carbon,
            'waktu' => $carbon,
            'deposit' => $request->deposit,
            'biaya' => $request->biaya,
            'bonus' => $request->bonus,
            'jenis_kelas' => $request->jenis_kelas,
            'total_deposit' => $request->total_deposit,
            'total_deposit' => $request->deposit+$request->bonus,
            'masa_berlaku' => $request->masa_berlaku,
            'id_pegawai' => $request->id_pegawai,
            'nama_pegawai' => $request->nama_pegawai    
        ]);

        return new DepositPaketResource(true, 'Data Paket Berhasil  Ditambahkan!', $paket);
        
            return redirect()->route('paket.index')->with(['success'
                => 'Data Berhasil Disimpan!']);

    }

    public function show($id){
        $paket = DepositPaket::find($id); //find user by id

        if (!is_null($paket)) {
            return response([
                'message' => 'Retrive User Success',
                'data' => $paket
            ], 200); //return user data by id
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404); //return if user by id not found 
    }
}
