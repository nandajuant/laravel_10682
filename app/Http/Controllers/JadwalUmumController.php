<?php

namespace App\Http\Controllers;

use App\Models\JadwalUmum;
use Illuminate\Http\Request;
use App\Http\Resources\JadwalUmumResource;
use Illuminate\Support\Facades\Validator;

class JadwalUmumController extends Controller
{
    //
    public function index()
    {
        // $member = Member::get();

        // return view('member.index', compact('member'));

        $jadwalUmum = JadwalUmum::latest()->get();
        //render view with posts
        return new JadwalUmumResource(true, 'List Data Jadwal',
        $jadwalUmum);
    }

    public function create()
    {
        return view('jadwal_umum.create');
    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_pegawai' => 'required',
            'id_kelas' => 'required',
            'hari' => 'required',
            'waktu' => 'required',
            'jenis_kelas' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Fungsi Post ke Database
        $jadwal_umum = JadwalUmum::create([
            'id' => $request->id,
            'id_pegawai' => $request->id_pegawai,
            'id_kelas' => $request->id_kelas,
            'hari' => $request->hari,
            'waktu' => $request->waktu,
            'jenis_kelas' => $request->jenis_kelas
        ]);

        return new JadwalUmumResource(true, 'Data JadwalUmum Berhasil  Ditambahkan!', $jadwal_umum);
        
            return redirect()->route('jadwal_umum.index')->with(['success'
                => 'Data Berhasil Disimpan!']);

    }

        public function edit($id)
        {
            $data = array(
                'content' => 'jadwal_umum',
                'jadwal_umums' => JadwalUmum::find($id)
            );

            return view('jadwal_umum.edit')->with($data);
        }

        public function update(Request $request, $id)
        {
            //Validasi Formulir
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'id_pegawai' => 'required',
                'id_kelas' => 'required',
                'hari' => 'required',
                'waktu' => 'required',
                'jenis_kelas' => 'required',
            ]); 

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $jadwal_umums = JadwalUmum::findOrFail($id);

            if($jadwal_umums) {

                //update post
                $jadwal_umums->update([
                    'id' => $request->id,
                    'id_pegawai' => $request->id_pegawai,
                    'id_kelas' => $request->id_kelas,
                    'hari' => $request->hari,
                    'waktu' => $request->waktu,
                    'jenis_kelas' => $request->jenis_kelas
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $jadwal_umums
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);

        return redirect()->route('jadwal_umum.index')->with(['success'
            => 'Data Berhasil Diubah!']);

        }

        public function destroy($id)
        {
            $jadwal_umum = JadwalUmum::findOrfail($id);

            if($jadwal_umum) {

                //delete post
                $jadwal_umum->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'JadwalUmum Deleted',
                ], 200);

            }

            //data post not found
            return response()->json([
                'success' => false,
                'message' => 'JadwalUmum Not Found',
            ], 404);
            
            //redirect to index
            return redirect()->route('jadwal_umum.index')->with(['success'
            => 'Data Berhasil Dihapus']);
        }

        public function show($id){
            $jadwal_umum = JadwalUmum::find($id); //find user by id
    
            if (!is_null($jadwal_umum)) {
                return response([
                    'message' => 'Retrive User Success',
                    'data' => $jadwal_umum
                ], 200); //return user data by id
            }
    
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404); //return if user by id not found 
        }
}
