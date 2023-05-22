<?php

namespace App\Http\Controllers;

use App\Http\Resources\KelasResource;
use App\Models\Kelas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    //
    public function index()
    {
        // $kelas = Kelas::get();

        // return view('kelas.index', compact('kelas'));

        $kelas = Kelas::latest()->get();
        //render view with posts
        return new KelasResource(true, 'List Data Kelas',
        $kelas);
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Fungsi Post ke Database
        $kelas = Kelas::create([
            'id_kelas' => $request->id_kelas,
            'id_instruktur' => $request->id_instruktur,
            'nama_instruktur' => $request->nama_instruktur,
            'nama_kelas' => $request->nama_kelas,
            'tarif' => $request->tarif,
            'deskripsi' => $request->deskripsi,
        ]);

        return new KelasResource(true, 'Data Kelas Berhasil  Ditambahkan!', $kelas);
        
            return redirect()->route('kelas.index')->with(['success'
                => 'Data Berhasil Disimpan!']);

    }

        public function edit($id)
        {
            $data = array(
                'content' => 'kelas',
                'instrukturs' => Kelas::find($id)
            );

            return view('kelas.edit')->with($data);
        }

        public function update(Request $request, $id)
        {
            //Validasi Formulir
            $validator = Validator::make($request->all(), [
                
            ]); 

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $instrukturs = Kelas::findOrFail($id);

            if($instrukturs) {

                //update post
                $instrukturs->update([
                    'id_kelas' => $request->id_kelas,
                    'id_instruktur' => $request->id_instruktur,
                    'nama_instruktur' => $request->nama_instruktur,
                    'nama_kelas' => $request->nama_kelas,
                    'tarif' => $request->tarif,
                    'deskripsi' => $request->deskripsi,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $instrukturs
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);

        return redirect()->route('kelas.index')->with(['success'
            => 'Data Berhasil Diubah!']);

        }

        public function destroy($id)
        {
            $kelas = Kelas::findOrfail($id);

            if($kelas) {

                //delete post
                $kelas->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Kelas Deleted',
                ], 200);

            }

            //data post not found
            return response()->json([
                'success' => false,
                'message' => 'Kelas Not Found',
            ], 404);
            
            //redirect to index
            return redirect()->route('kelas.index')->with(['success'
            => 'Data Berhasil Dihapus']);
        }

        public function show($id){
            $kelas = Kelas::find($id); //find user by id
    
            if (!is_null($kelas)) {
                return response([
                    'message' => 'Retrive User Success',
                    'data' => $kelas
                ], 200); //return user data by id
            }
    
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404); //return if user by id not found 
        }
}
