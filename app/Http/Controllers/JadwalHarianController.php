<?php

namespace App\Http\Controllers;

use App\Models\JadwalHarian;
use Illuminate\Http\Request;
use App\Http\Resources\JadwalHarianResource;
use App\Models\JadwalUmum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class JadwalHarianController extends Controller
{
    //
    public function index()
    {
        // $member = Member::get();

        // return view('member.index', compact('member'));

        $jadwalHarian = JadwalHarian::latest()->get();
        //render view with posts
        return new JadwalHarianResource(true, 'List Data Jadwal',
        $jadwalHarian);
    }

    public function create()
    {
        return view('jadwal_harian.create');
    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            // 'id' => 'required',
            // 'id_pegawai' => 'required',
            'id_kelas' => 'required',
            'hari' => 'required',
            'waktu' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required',
            'jenis_kelas' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $totalJadwal = sprintf('%02d',(JadwalHarian::all()->count())+1);
        
        //Fungsi Post ke Database
        $jadwal_harian = JadwalHarian::create([
            'id' => $totalJadwal,
            'id_pegawai' => $request->id_pegawai,
            'id_kelas' => $request->id_kelas,
            'hari' => $request->hari,
            'waktu' => $request->waktu,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
            'jenis_kelas' => $request->jenis_kelas
        ]);

        return new JadwalHarianResource(true, 'Data JadwalHarian Berhasil  Ditambahkan!', $jadwal_harian);
        
            return redirect()->route('jadwal_harian.index')->with(['success'
                => 'Data Berhasil Disimpan!']);

    }

        public function edit($id)
        {
            $data = array(
                'content' => 'jadwal_harian',
                'jadwal_harians' => JadwalHarian::find($id)
            );

            return view('jadwal_harian.edit')->with($data);
        }

        public function update(Request $request, $id)
        {
            //Validasi Formulir
            $validator = Validator::make($request->all(), [
                // 'id' => 'required',
                // 'id_pegawai' => 'required',
                'id_kelas' => 'required',
                'hari' => 'required',
                'waktu' => 'required',
                'keterangan' => 'required',
                'tanggal' => 'required',
                'jenis_kelas' => 'required',
            ]); 

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $jadwal_harians = JadwalHarian::findOrFail($id);

            if($jadwal_harians) {

                //update post
                $jadwal_harians->update([
                    // 'id' => $request->id,
                    // 'id_pegawai' => $request->id_pegawai,
                    'id_kelas' => $request->id_kelas,
                    'hari' => $request->hari,
                    'waktu' => $request->waktu,
                    'keterangan' => $request->keterangan,
                    'tanggal' => $request->tanggal,
                    'jenis_kelas' => $request->jenis_kelas
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $jadwal_harians
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);

        return redirect()->route('jadwal_harian.index')->with(['success'
            => 'Data Berhasil Diubah!']);

        }

        public function destroy()
        {
            $jadwal_harian = JadwalHarian::all();

            if($jadwal_harian) {

                //delete post
                $jadwal_harian->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'JadwalHarian Deleted',
                ], 200);

            }

            //data post not found
            return response()->json([
                'success' => false,
                'message' => 'JadwalHarian Not Found',
            ], 404);
            
            //redirect to index
            return redirect()->route('jadwal_harian.index')->with(['success'
            => 'Data Berhasil Dihapus']);
        }

        public function show($id){
            $jadwal_harian = JadwalHarian::find($id); //find user by id
    
            if (!is_null($jadwal_harian)) {
                return response([
                    'message' => 'Retrive User Success',
                    'data' => $jadwal_harian
                ], 200); //return user data by id
            }
    
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404); //return if user by id not found 
        }

    public function generateJadwalHarian()
    {
        $existingJadwalHarian = JadwalHarian::exists();

        if ($existingJadwalHarian) {
            return response()->json(['message' => 'Jadwal Harian sudah ada'], 400);
        }
        else {
            // Mengambil data JadwalUmum
            $jadwalUmum = JadwalUmum::all();

            $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $todayIndex = Carbon::now()->dayOfWeekIso - 1; // Mengambil indeks hari saat ini
            $weekStartDate = Carbon::now()->startOfWeek();

            foreach ($jadwalUmum as $jadwal) {
                // Mendapatkan indeks hari dari JadwalUmum
                $jadwalIndex = array_search($jadwal->hari, $daysOfWeek);

                // Menghitung selisih hari antara hari saat ini dengan hari JadwalUmum
                $diff = $jadwalIndex - $todayIndex;
                $tanggal = Carbon::now()->addDays($diff)->format('Y-m-d');
                
                // Membuat objek JadwalHarian baru
                $jadwalHarian = new JadwalHarian();
                $jadwalHarian->id = $jadwal->id;
                $jadwalHarian->id_pegawai = $jadwal->id_pegawai; 
                $jadwalHarian->id_kelas = $jadwal->id_kelas;
                $jadwalHarian->hari = $jadwal->hari;
                $jadwalHarian->waktu = $jadwal->waktu;
                $jadwalHarian->tanggal = $tanggal;
                $jadwalHarian->save();
            }

            return response()->json(['message' => 'Berhasil Menggenerate Jadwal Harian']);
        }

    }
}
