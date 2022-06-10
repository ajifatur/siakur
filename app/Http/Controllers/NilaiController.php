<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\Helpers\DateTimeExt;
use App\Models\Jadwal;
use App\Models\User;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check the access
        // has_access(method(__METHOD__), Auth::user()->role_id);

        if(Auth::user()->role_id == role('guru')) {
            // Mengambil data guru mapel
            $guru_mapel = Auth::user()->guru->guru_mapel;

            // Mengambil data jadwal
            $jadwal = Jadwal::has('rombel')->whereIn('gurumapel_id',$guru_mapel->pluck('id')->toArray())->where('ta_id','=',session()->get('taa'))->groupBy('rombel_id')->get();

            // View
            return view('admin/nilai/index', [
                'guru_mapel' => $guru_mapel,
                'jadwal' => $jadwal,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check the access
        // has_access(method(__METHOD__), Auth::user()->role_id);

        // View
        return view('admin/guru/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:200',
            'nomor_identitas' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_telepon' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
            'username' => 'required|alpha_dash',
            'password' => 'required'
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan guru
            $guru = new Guru;
            $guru->user_id = 0;
            $guru->nama = $request->nama;
            $guru->nomor_identitas = $request->nomor_identitas;
            $guru->jenis_kelamin = $request->jenis_kelamin;
            $guru->tempat_lahir = $request->tempat_lahir;
            $guru->tanggal_lahir = DateTimeExt::change($request->tanggal_lahir);
            $guru->nomor_telepon = $request->nomor_telepon;
            $guru->alamat = $request->alamat;
            $guru->save();

            // Simpan user
            $user = new User;
            $user->role_id = role('guru');
            $user->name = $guru->nama;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->status = 1;
            $user->save();

            // Update data guru
            $guru->user_id = $user->id;
            $guru->save();

            // Redirect
            return redirect()->route('admin.guru.index')->with(['message' => 'Berhasil menambah data.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check the access
        // has_access(method(__METHOD__), Auth::user()->role_id);

        // Mengambil data guru
        $guru = Guru::findOrFail($id);

        // View
        return view('admin/guru/edit', [
            'guru' => $guru
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Mengambil data user
        $guru = Guru::find($request->id);
        $user = User::find($guru->user_id);

        // Validation
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:200',
            'nomor_identitas' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_telepon' => 'required',
            'alamat' => 'required',
            'email' => [
                'required', 'email',
                $user ? Rule::unique('users')->ignore($user->id, 'id') : ''
            ],
            'username' => [
                'required', 'alpha_dash',
                $user ? Rule::unique('users')->ignore($user->id, 'id') : ''
            ],
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update data guru
            $guru = Guru::find($request->id);
            $guru->nama = $request->nama;
            $guru->nomor_identitas = $request->nomor_identitas;
            $guru->jenis_kelamin = $request->jenis_kelamin;
            $guru->tempat_lahir = $request->tempat_lahir;
            $guru->tanggal_lahir = DateTimeExt::change($request->tanggal_lahir);
            $guru->nomor_telepon = $request->nomor_telepon;
            $guru->alamat = $request->alamat;
            $guru->save();

            // Update data user
            if(!$user) $user = new User;
            $user->role_id = role('guru');
            $user->name = $guru->nama;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = $request->password != '' ? bcrypt($request->password) : $user->password;
            $user->status = 1;
            $user->save();

            // Update data guru
            $guru->user_id = $user->id;
            $guru->save();

            // Redirect
            return redirect()->route('admin.guru.index')->with(['message' => 'Berhasil mengupdate data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check the access
        // has_access(method(__METHOD__), Auth::user()->role_id);
        
        // Mengambil data guru
        $guru = Guru::find($request->id);

        // Menghapus data guru
        $guru->delete();

        // Redirect
        return redirect()->route('admin.guru.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
