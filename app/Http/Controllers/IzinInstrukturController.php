<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\IzinInstrukturResource;
use App\Models\IzinInstruktur;
use Illuminate\Support\Facades\Validator;

class IzinInstrukturController extends Controller
{
    //
    public function index()
    {
        // $member = Member::get();

        // return view('member.index', compact('member'));

        $izinInstruktur = IzinInstruktur::latest()->get();
        //render view with posts
        return new IzinInstrukturResource(true, 'List Data Izin',
        $izinInstruktur);
    }

    public function create()
    {
        return view('izin_instruktur.create');
    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            // 'id_izin' => 'required',
            'id_instruktur' => 'required',
            'id_jadwal_harian' => 'required',
            'nama' => 'required',
            'tanggal' => 'required',
            // 'status' => 'required',
            'keterangan' => 'required',
            'id_pegawai' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $total = sprintf('%02d',(IzinInstruktur::all()->count())+1);
        $carbon=\Carbon\Carbon::now();
        $dateYY=$carbon->format('y');
        // $expireddateYY=\Carbon\Carbon::now()->addMonths(3);
        $dateMM=$carbon->format('m');
        $id_izin=$dateYY.'.'.$dateMM.'.'.$total;
        //Fungsi Post ke Database
        $instruktur = IzinInstruktur::create([
            'id_izin' => $id_izin,
            'id_instruktur' => $request->id_instruktur,
            'id_jadwal_harian' => $request->id_jadwal_harian,
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            // 'status' => $request->status,
            'keterangan' => $request->keterangan
        ]);

        return new IzinInstrukturResource(true, 'Data Izin Berhasil  Ditambahkan!', $instruktur);
        
            return redirect()->route('izinInstruktur.index')->with(['success'
                => 'Data Berhasil Disimpan!']);

    }

        public function edit($id_izin)
        {
            $data = array(
                'content' => 'instruktur',
                'izin_instrukturs' => IzinInstruktur::find($id_izin)
            );

            return view('izin_instruktur.edit')->with($data);
        }

        public function update(Request $request, $id_izin)
        {
            //Validasi Formulir
            $validator = Validator::make($request->all(), [
                // // 'id_izin' => 'required',
                // 'id_instruktur' => 'required',
                // 'id_jadwal_harian' => 'required',
                // 'nama' => 'required',
                // 'tanggal' => 'required',
                'status' => 'required',
                // 'keterangan' => 'required',
                // 'id_pegawai' => 'required',
            ]); 

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $izinInstrukturs = IzinInstruktur::findOrFail($id_izin);

            if($izinInstrukturs) {

                //update post
                $izinInstrukturs->update([
                    // 'id_izin' => $request->id_izin,
                    // 'id_instruktur' => $request->id_instruktur,
                    // 'id_jadwal_harian' => $request->id_jadwal_harian,
                    // 'nama' => $request->nama,
                    // 'tanggal' => $request->tanggal,
                    'status' => $request->status,
                    // 'keterangan' => $request->keterangan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $izinInstrukturs
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);

        return redirect()->route('instruktur.index')->with(['success'
            => 'Data Berhasil Diubah!']);

        }


        public function show($id_izin){
            $izinInstruktur = IzinInstruktur::find($id_izin); //find user by id
    
            if (!is_null($izinInstruktur)) {
                return response([
                    'message' => 'Retrive User Success',
                    'data' => $izinInstruktur
                ], 200); //return user data by id
            }
    
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404); //return if user by id not found 
        }

}
