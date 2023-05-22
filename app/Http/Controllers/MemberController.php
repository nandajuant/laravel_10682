<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\MemberResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    //
    public function index()
    {
        // $member = Member::get();

        // return view('member.index', compact('member'));

        $member = Member::latest()->get();
        //render view with posts
        return new MemberResource(true, 'List Data Member',
        $member);
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {
        

        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            // 'id_member'=>'required',
            'id_member' => 'required',
            'nama' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'jml_dep_kelas' => 'required',
            'jml_dep_uang' => 'required',
            'kadaluarsa_member' => 'required',
            'kadaluarsa_deposit' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
            }
            //Fungsi Post ke Database
            $member = Member::create([
                // 'id_member' => $request->id_member,
                'id_member' => $request->id_member,
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'jml_dep_kelas' => $request ->jml_dep_kelas,
                'jml_dep_uang' => $request ->jml_dep_uang,
                'kadaluarsa_member' => $request ->kadaluarsa_member,
                'kadaluarsa_deposit' => $request ->kadaluarsa_deposit,
                'status' => $request->status
            ]);
            return new MemberResource(true, 'Data Member Berhasil  Ditambahkan!', $member);
        
            return redirect()->route('member.index')->with(['success'
                => 'Data Berhasil Disimpan!']);

        }

        public function edit($id_member)
        {
            $data = array(
                'content' => 'member',
                'members' => Member::find($id_member)
            );

            return view('member.edit')->with($data);
        }

        public function update(Request $request, $id_member)
        {
            //Validasi Formulir
            $validator = Validator::make($request->all(), [
                // 'id_member' => 'required',
                'id_member' => 'required',
                'nama' => 'required',
                'no_hp' => 'required|numeric|digits_between:10,13',
                'alamat' => 'required',
                'jml_dep_kelas' => 'required',
                'jml_dep_uang' => 'required',
                'kadaluarsa_member' => 'required',
                'kadaluarsa_deposit' => 'required',
                'status' => 'required'
            ]); 

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $members = Member::findOrFail($id_member);

            if($members) {

                //update post
                $members->update([
                    // 'id_member' => $request->id_member,
                    'id_member' => $request->id_member,
                    'nama' => $request->nama,
                    'no_hp' => $request->no_hp,
                    'alamat' => $request->alamat,
                    'jml_dep_kelas' => $request ->jml_dep_kelas,
                    'jml_dep_uang' => $request ->jml_dep_uang,
                    'kadaluarsa_member' => $request ->kadaluarsa_member,
                    'kadaluarsa_deposit' => $request ->kadaluarsa_deposit,
                    'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $members
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);

        return redirect()->route('member.index')->with(['success'
            => 'Data Berhasil Diubah!']);

        }

        public function destroy($id_member)
        {
            $member = Member::findOrfail($id_member);

            if($member) {

                //delete post
                $member->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Member Deleted',
                ], 200);

            }

            //data post not found
            return response()->json([
                'success' => false,
                'message' => 'Member Not Found',
            ], 404);
            
            //redirect to index
            return redirect()->route('member.index')->with(['success'
            => 'Data Berhasil Dihapus']);
        }

        public function show($id_member){
            $member = Member::findOrfail($id_member); //find user by id_member
    
            if (!is_null($member)) {
                return response([
                    'message' => 'Retrive User Success',
                    'data' => $member
                ], 200); //return user data by id_member
            }
    
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404); //return if user by id_member not found 
        }

        public function reset($id_member){
            $member = Member::find($id_member);

            $member->password = Hash::make($member->tanggal_lahir);

            //diubah//
            
            $member->update();
    
            return response([
                'message' => 'Reset Password Member Success',
                'data' => $member
            ], 200);
        }

        public function resetDeposit(){
            // $updateData = $request->all();

            // $today = Carbon::today()->toDateString();
            // // $carbon=\Carbon\Carbon::now();
            // // $dateYY=$carbon->format('y');
            // // $dateMM=$carbon->format('m');
            // // Loop through each table and update the desired columns
            // foreach ($updateData as $table => $columns) {
            //     // Member::where('id', $table)->update($columns);
            //     if (Schema::hasColumn($table, 'kadaluarsa_member')) {
            //         Member::where('kadaluarsa_member', $today)->update(['status'=>0]);
            //     }
            // }

            // // Optionally, you can redirect the user back or display a success message
            // return redirect()->back()->with('success', 'Tables updated successfully.');
           
        
            $members = member::where('kadaluarsa_deposit', '<=', Carbon::today())->get();

            foreach ($members as $member) {
                $member->jml_dep_kelas = 0;
                $member->kadaluarsa_deposit = null;
                $member->save();
            }

            return response([
                'message' => 'Members deposit updated successfully',
                'data' => $members
            ], 200);
        }

        public function showResetDeposit(){   
        
            $members = member::where('kadaluarsa_deposit', '<=', Carbon::today())->get();

            if (count($members) > 0) {
                return response([
                    'message' => 'Retrieve All Success',
                    'data' => $members
                ], 200);
            }
            
            return response([
                'message' => 'Empty',
                'data' => null
            ], 200);
        }

        public function deaktivasi(){
            // Retrieve the update data from the request
            // $updateData = $request->all();

            // $today = Carbon::today()->toDateString();
            // $carbon=\Carbon\Carbon::now();
            // $dateYY=$carbon->format('y');
            // $dateMM=$carbon->format('m');
            // Loop through each table and update the desired columns
            // foreach ($updateData as $table => $columns) {
            //     // Member::where('id', $table)->update($columns);
            //     if (Schema::hasColumn($table, 'kadaluarsa_member')) {
            //         Member::where('kadaluarsa_member', $today)->update(['status'=>0]);
            //     }
            // }

            // Optionally, you can redirect the user back or display a success message
            // return redirect()->back()->with('success', 'Tables updated successfully.');

            $members = member::where('kadaluarsa_member', '<=', Carbon::today())->get();

            foreach ($members as $member) {
                $member->status = 0;
                $member->kadaluarsa_member = null;
                $member->save();
            }

            return response([
                'message' => 'Members membership updated successfully',
                'data' => $members
            ], 200);

        }

        public function showDeaktivasi(){

            $members = member::where('kadaluarsa_member', '<=', Carbon::today())->get();

            if (count($members) > 0) {
                return response([
                    'message' => 'Retrieve All Success',
                    'data' => $members
                ], 200);
            }
    
            return response([
                'message' => 'Empty',
                'data' => null
            ], 200);

        }

    


}
