<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instruktur;

use App\Http\Resources\InstrukturResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InstrukturController extends Controller
{
    //
    public function index()
    {
        // $instruktur = Instruktur::get();

        // return view('instruktur.index', compact('instruktur'));

        $instruktur = Instruktur::latest()->get();
        //render view with posts
        return new InstrukturResource(true, 'List Data Instruktur',
        $instruktur);
    }

    public function create()
    {
        return view('instruktur.create');
    }

    public function store(Request $request)
    {
        
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama' => 'required',
            'no_hp' => 'required|numeric|digits_between:10,13',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Fungsi Post ke Database
        $instruktur = Instruktur::create([
            'id' => $request->id,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return new InstrukturResource(true, 'Data Instruktur Berhasil  Ditambahkan!', $instruktur);
        
            return redirect()->route('instruktur.index')->with(['success'
                => 'Data Berhasil Disimpan!']);

    }

        public function edit($id)
        {
            $data = array(
                'content' => 'instruktur',
                'instrukturs' => Instruktur::find($id)
            );

            return view('instruktur.edit')->with($data);
        }

        public function update(Request $request, $id)
        {
            //Validasi Formulir
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'nama' => 'required',
                'no_hp' => 'required|numeric|digits_between:10,13',
                'alamat' => 'required',
            ]); 

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $instrukturs = Instruktur::findOrFail($id);

            if($instrukturs) {

                //update post
                $instrukturs->update([
                    'id' => $request->id,
                    'nama' => $request->nama,
                    'no_hp' => $request->no_hp,
                    'alamat' => $request->alamat,
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

        return redirect()->route('instruktur.index')->with(['success'
            => 'Data Berhasil Diubah!']);

        }

        public function destroy($id)
        {
            $instruktur = Instruktur::findOrfail($id);

            if($instruktur) {

                //delete post
                $instruktur->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Instruktur Deleted',
                ], 200);

            }

            //data post not found
            return response()->json([
                'success' => false,
                'message' => 'Instruktur Not Found',
            ], 404);
            
            //redirect to index
            return redirect()->route('instruktur.index')->with(['success'
            => 'Data Berhasil Dihapus']);
        }

        public function show($id){
            $instruktur = Instruktur::find($id); //find user by id
    
            if (!is_null($instruktur)) {
                return response([
                    'message' => 'Retrive User Success',
                    'data' => $instruktur
                ], 200); //return user data by id
            }
    
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404); //return if user by id not found 
        }

        function loginAndroid(Request $request) {
            $logins = DB::table('instrukturs')
             ->where('email', $request->email)
             ->where('password', $request->password)
             ->get();
          
            if (count($logins) > 0) {
             foreach ($logins as $logg) {
              $result["success"] = "1";
              $result["message"] = "success";
              //untuk memanggil data sesi Login
              $result["id"] = $logg->id;
              $result["nama"] = $logg->nama;
              $result["no_hp"] = $logg->nim;
              $result["alamat"] = $logg->alamat;
             }
             echo json_encode($result);
            } else {
             $result["success"] = "0";
             $result["message"] = "error";
             echo json_encode($result);
            }
           }
}
