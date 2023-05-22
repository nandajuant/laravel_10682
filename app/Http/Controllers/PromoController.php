<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use App\Http\Resources\PromoResource;
use Illuminate\Support\Facades\Validator;

class PromoController extends Controller
{
    //
    public function index()
    {
        // $member = Member::get();

        // return view('member.index', compact('member'));

        $promo = Promo::latest()->get();
        //render view with posts
        return new PromoResource(true, 'List Data Promo',
        $promo);
    }

    public function create()
    {
        return view('promo.create');
    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jenis' => 'required',
            'detail' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Fungsi Post ke Database
        $promo = Promo::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'detail' => $request->detail,
        ]);

        return new PromoResource(true, 'Data Promo Berhasil  Ditambahkan!', $promo);
        
            return redirect()->route('promo.index')->with(['success'
                => 'Data Berhasil Disimpan!']);

    }

        public function edit($id)
        {
            $data = array(
                'content' => 'promo',
                'promos' => Promo::find($id)
            );

            return view('promo.edit')->with($data);
        }

        public function update(Request $request, $id)
        {
            //Validasi Formulir
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'jenis' => 'required',
                'detail' => 'required',
            ]); 

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $promos = Promo::findOrFail($id);

            if($promos) {

                //update post
                $promos->update([
                    'nama' => $request->nama,
                    'jenis' => $request->jenis,
                    'detail' => $request->detail,
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $promos
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);

        return redirect()->route('promo.index')->with(['success'
            => 'Data Berhasil Diubah!']);

        }

        public function destroy($id)
        {
            $promo = Promo::findOrfail($id);

            if($promo) {

                //delete post
                $promo->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Promo Deleted',
                ], 200);

            }

            //data post not found
            return response()->json([
                'success' => false,
                'message' => 'Promo Not Found',
            ], 404);
            
            //redirect to index
            return redirect()->route('promo.index')->with(['success'
            => 'Data Berhasil Dihapus']);
        }

        public function show($id){
            $promo = Promo::find($id); //find user by id
    
            if (!is_null($promo)) {
                return response([
                    'message' => 'Retrive User Success',
                    'data' => $promo
                ], 200); //return user data by id
            }
    
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404); //return if user by id not found 
        }
}
