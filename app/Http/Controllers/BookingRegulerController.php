<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingRegulerResource;
use App\Models\BookingReguler;
use App\Models\Instruktur;
use App\Models\JadwalHarian;
use App\Models\Kelas;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingRegulerController extends Controller
{
    //
    public function index()
    {
        // $reguler = reguler::get();

        // return view('reguler.index', compact('reguler'));

        $reguler = BookingReguler::latest()->get();
        //render view with posts
        return new BookingRegulerResource(true, 'List Data Booking Reguler',
        $reguler);
    }

    public function create()
    {
        return view('booking_pkt.create');
    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $totalBooking = sprintf('%02d',(BookingReguler::all()->count())+1);
        $nama_member = Member::find($request->id_member);
        $jadwalharian = JadwalHarian::find($request->id_jadwal_harian);
        $idinstruktur = $jadwalharian->id_kelas;
        $kelas = Kelas::find($request->idinstruktur);
        $sisadep = $nama_member->jml_dep_uang;
        $tar = $kelas->tarif;
        $sisa = $sisadep - $tar;
        $carbon=\Carbon\Carbon::now();
        $dateYY=$carbon->format('y');
        // $expireddateYY=\Carbon\Carbon::now()->addMonths(3);
        $dateMM=$carbon->format('m');
        $id_booking=$dateYY.'.'.$dateMM.'.'.$totalBooking;
        //Fungsi Post ke Database
        $reguler = BookingReguler::create([
            'id_booking_reg' => $id_booking,
            'id_member' => $request->id_member,
            'nama' => $nama_member->nama,
            'id_instruktur' => $idinstruktur->id_instruktur,
            'id_jadwal_harian' => $request->id_jadwal_harian,
            'nama_instruktur' => $jadwalharian->nama_instruktur,
            'nama_kelas'=> $kelas->nama_kelas,
            'tanggal' => $carbon,
            'waktu' => $carbon,
            'tarif' => $tar,
            'sisa_deposit' => $sisa,
            'status' => $request->status,
        ]);

        return new BookingRegulerResource(true, 'Data Reguler Berhasil  Ditambahkan!', $reguler);
        
            return redirect()->route('reguler.index')->with(['success'
                => 'Data Berhasil Disimpan!']);

    }

    public function show($id){
        $reguler = BookingReguler::find($id); //find user by id

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

    public function edit($id_booking_pkt)
    {
        $data = array(
            'content' => 'booking_reguler',
            'booking_reguler' => BookingReguler::find($id_booking_pkt)
        );

        return view('booking_reguler.edit')->with($data);
    }

    public function update(Request $request, $id_booking_pkt)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            
        ]); 

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $reguler = BookingReguler::findOrFail($id_booking_pkt);

        if($reguler) {

            //update post
            $reguler->update([
                'status' => $request->status,
                
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post Updated',
            'data'    => $reguler
        ], 200);
    }

    return response()->json([
        'success' => false,
        'message' => 'Post Not Found',
    ], 404);

    return redirect()->route('booking_reguler.index')->with(['success'
        => 'Data Berhasil Diubah!']);

    }
}
