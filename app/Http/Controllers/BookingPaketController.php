<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\BookingPaketResource;
use App\Models\BookingPaket;
use App\Models\JadwalHarian;
use App\Models\Kelas;
use App\Models\Member;
use Illuminate\Support\Facades\Validator;

class BookingPaketController extends Controller
{
    //
    public function index()
    {
        // $paket = Paket::get();

        // return view('paket.index', compact('paket'));

        $paket = BookingPaket::latest()->get();
        //render view with posts
        return new BookingPaketResource(true, 'List Data Booking Paket',
        $paket);
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

        $totalBooking = sprintf('%02d',(BookingPaket::all()->count())+1);
        $nama_member = Member::find($request->id_member);
        $jadwalharian = JadwalHarian::find($request->id_jadwal_harian);
        $idinstruktur = $jadwalharian->id_kelas;
        $kelas = Kelas::find($request->idinstruktur);
        $sisapkt = $nama_member->jml_dep_kelas;
        $tar = $kelas->tarif;
        $sisa = $sisapkt - $tar;
        $carbon=\Carbon\Carbon::now();
        $dateYY=$carbon->format('y');
        // $expireddateYY=\Carbon\Carbon::now()->addMonths(3);
        $dateMM=$carbon->format('m');
        $id_booking=$dateYY.'.'.$dateMM.'.'.$totalBooking;
        //Fungsi Post ke Database
        $paket = BookingPaket::create([
            'id_booking_pkt' => $id_booking,
            'id_member' => $request->id_member,
            'nama' => $nama_member->nama,
            'id_instruktur' => $idinstruktur->id_instruktur,
            'id_jadwal_harian' => $request->id_jadwal_harian,
            'nama_instruktur' => $jadwalharian->nama_instruktur,
            'nama_kelas'=> $kelas->nama_kelas,
            'tanggal' => $carbon,
            'waktu' => $carbon,
            'tarif' => $tar,
            'sisa_paket' => $sisa,
            'masa_berlaku' => $nama_member->kadaluarsa_deposit,
            'status' => $request->status,
        ]);

        return new BookingPaketResource(true, 'Data Paket Berhasil  Ditambahkan!', $paket);
        
            return redirect()->route('paket.index')->with(['success'
                => 'Data Berhasil Disimpan!']);

    }

    public function show($id){
        $paket = BookingPaket::find($id); //find user by id

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

    public function edit($id_booking_pkt)
    {
        $data = array(
            'content' => 'booking_paket',
            'booking_paket' => BookingPaket::find($id_booking_pkt)
        );

        return view('booking_paket.edit')->with($data);
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

        $paket = BookingPaket::findOrFail($id_booking_pkt);

        if($paket) {

            //update post
            $paket->update([
                'status' => $request->status,
                
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post Updated',
            'data'    => $paket
        ], 200);
    }

    return response()->json([
        'success' => false,
        'message' => 'Post Not Found',
    ], 404);

    return redirect()->route('booking_paket.index')->with(['success'
        => 'Data Berhasil Diubah!']);

    }
}
