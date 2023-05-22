<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;

use App\Http\Resources\PegawaiResource;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    //
    public function index()
    {
        // $pegawai = Pegawai::get();

        // return view('pegawai.index', compact('pegawai'));

        $pegawai = Pegawai::latest()->get();
        //render view with posts
        return new PegawaiResource(true, 'List Data Pegawai',
        $pegawai);
    }

    public function create()
    {
        return view('pegawai.create');
    }

    public function store(Request $request)
    {
        

        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'id_pegawai' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
            }
            //Fungsi Post ke Database
            $pegawai = Pegawai::create([
                'id_pegawai' => $request->id_pegawai,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
            return new PegawaiResource(true, 'Data Pegawai Berhasil  Ditambahkan!', $pegawai);
        
            return redirect()->route('pegawai.index')->with(['success'
                => 'Data Berhasil Disimpan!']);

        }

        public function edit($id_pegawai)
        {
            $data = array(
                'content' => 'pegawai',
                'pegawais' => Pegawai::find($id_pegawai)
            );

            return view('pegawai.edit')->with($data);
        }

        public function update(Request $request, $id_pegawai)
        {
            //Validasi Formulir
            $validator = Validator::make($request->all(), [
                // 'id_pegawai' => 'required',
                'nama' => 'required',
                'jabatan' => 'required',
                'no_hp' => 'required|numeric|digits_between:10,13',
                'alamat' => 'required',
            ]); 

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $pegawais = Pegawai::findOrFail($id_pegawai);

            if($pegawais) {

                //update post
                $pegawais->update([
                    // 'id_pegawai' => $request->id_pegawai,
                    'nama' => $request->nama,
                    'jabatan' => $request->jabatan,
                    'no_hp' => $request->no_hp,
                    'alamat' => $request->alamat,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $pegawais
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);

        return redirect()->route('pegawai.index')->with(['success'
            => 'Data Berhasil Diubah!']);

        }

        public function destroy($id_pegawai)
        {
            $pegawai = Pegawai::findOrfail($id_pegawai);

            if($pegawai) {

                //delete post
                $pegawai->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Pegawai Deleted',
                ], 200);

            }

            //data post not found
            return response()->json([
                'success' => false,
                'message' => 'Pegawai Not Found',
            ], 404);
            
            //redirect to index
            return redirect()->route('pegawai.index')->with(['success'
            => 'Data Berhasil Dihapus']);
        }

    //show spesific user by id_pegawai
    public function show($id_pegawai){
        $users = Pegawai::find($id_pegawai); //find user by id_pegawai

        if (!is_null($users)) {
            return response([
                'message' => 'Retrive User Success',
                'data' => $users
            ], 200); //return user data by id_pegawai
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404); //return if user by id_pegawai not found 
    }
}
