<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingGymResource;
use App\Models\BookingGym;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingGymController extends Controller
{
    //
    public function index()
    {
        // $gym = gym::get();

        // return view('gym.index', compact('gym'));

        $gym = BookingGym::latest()->get();
        //render view with posts
        return new BookingGymResource(true, 'List Data Booking Gym',
        $gym);
    }

    public function create()
    {
        return view('booking_gym.create');
    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $totalBooking = sprintf('%02d',(BookingGym::all()->count())+1);
        $nama_member = Member::find($request->id_member);
        $carbon=\Carbon\Carbon::now();
        $dateYY=$carbon->format('y');
        // $expireddateYY=\Carbon\Carbon::now()->addMonths(3);
        $dateMM=$carbon->format('m');
        $id_booking=$dateYY.'.'.$dateMM.'.'.$totalBooking;
        $last = BookingGym::latest()->get();
        $sisa = $last->sisa_kuota - 1;
        //Fungsi Post ke Database
        $gym = BookingGym::create([
            'id_gym' => $id_booking,
            'bulan' => $dateMM,
            'tanggal' => $carbon,
            'waktu' => $carbon,
            'slot_waktu' => $request->slot_waktu,
            'sisa_kuota' => $sisa,
            'id_member' => $request->id_member,
            'nama' => $nama_member->nama,
            'status' => $request->status,
        ]);

        return new BookingGymResource(true, 'Data gym Berhasil  Ditambahkan!', $gym);
        
            return redirect()->route('booking_gym.index')->with(['success'
                => 'Data Berhasil Disimpan!']);

    }

    public function show($id){
        $gym = BookingGym::find($id); //find user by id

        if (!is_null($gym)) {
            return response([
                'message' => 'Retrive User Success',
                'data' => $gym
            ], 200); //return user data by id
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404); //return if user by id not found 
    }

    public function edit($id_gym)
    {
        $data = array(
            'content' => 'gym',
            'booking_gym' => BookingGym::find($id_gym)
        );

        return view('booking_gym.edit')->with($data);
    }

    public function update(Request $request, $id_gym)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            
        ]); 

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $gym = BookingGym::findOrFail($id_gym);

        if($gym) {

            //update post
            $gym->update([
                'status' => $request->status,
                
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post Updated',
            'data'    => $gym
        ], 200);
    }

    return response()->json([
        'success' => false,
        'message' => 'Post Not Found',
    ], 404);

    return redirect()->route('booking_gym.index')->with(['success'
        => 'Data Berhasil Diubah!']);

    }
}
