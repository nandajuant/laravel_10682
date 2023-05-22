<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepositRegulerResource;
use App\Models\DepositReguler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepositRegulerController extends Controller
{
    //
    public function index()
    {
        // $reguler = Reguler::get();

        // return view('reguler.index', compact('reguler'));

        $reguler = DepositReguler::latest()->get();
        //render view with posts
        return new DepositRegulerResource(true, 'List Data Deposit Reguler',
        $reguler);
    }

    public function create()
    {
        return view('deposit_reg.create');
    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deposit' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $totalReguler = sprintf('%02d',(DepositReguler::all()->count())+1);
        $carbon=\Carbon\Carbon::now();
        $dateYY=$carbon->format('y');
        // $expireddateYY=\Carbon\Carbon::now()->addMonths(3);
        $dateMM=$carbon->format('m');
        $id_reguler=$dateYY.'.'.$dateMM.'.'.$totalReguler;
        //Fungsi Post ke Database
        $reguler = DepositReguler::create([
            'id' => $totalReguler,
            'id_deposit_reg' => $id_reguler,
            'id_promo' => $request->id_promo,
            'id_member' => $request->id_member,
            'nama' => $request->nama,
            'tanggal' => $carbon,
            'waktu' => $carbon,
            'deposit' => $request->deposit,
            'bonus' => $request->bonus,
            'sisa' => $request->sisa,
            // $total=deposit+bonus+sisa,
            'total' => $request->total,
            'id_pegawai' => $request->id_pegawai,
            'nama_pegawai' => $request->nama_pegawai    
        ]);

        return new DepositRegulerResource(true, 'Data Reguler Berhasil  Ditambahkan!', $reguler);
        
            return redirect()->route('reguler.index')->with(['success'
                => 'Data Berhasil Disimpan!']);

    }

    public function show($id){
        $reguler = DepositReguler::find($id); //find user by id

        if (!is_null($reguler)) {
            return response([
                'message' => 'Retrive User Success',
                'data' => $reguler
            ], 200); //return user data by id
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404); //return if user by id not found 
    }
}
