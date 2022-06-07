<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\TahunAkademik;

class TahunAkademikController extends Controller
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

        // Mengambil data tahun akademik
        $tahun_akademik = TahunAkademik::orderBy('status','desc')->get();

        // View
        return view('admin/tahun-akademik/index', [
            'tahun_akademik' => $tahun_akademik
        ]);
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
        return view('admin/tahun-akademik/create');
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
            'tahun' => 'required',
            'semester' => 'required',
            'status' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan tahun akademik
            $tahun_akademik = new TahunAkademik;
            $tahun_akademik->tahun = $request->tahun;
            $tahun_akademik->semester = $request->semester;
            $tahun_akademik->status = $request->status;
            $tahun_akademik->save();

            // Jika status aktif, maka otomatis mengganti tahun akademik lain menjadi tidak aktif
            if($tahun_akademik->status == 1) {
                $array = TahunAkademik::where('status','=',1)->where('id','!=',$tahun_akademik->id)->pluck('id')->toArray();
                if(count($array) > 0) {
                    foreach($array as $a) {
                        $taa = TahunAkademik::find($a);
                        $taa->status = 0;
                        $taa->save();
                    }
                }
            }

            // Redirect
            return redirect()->route('admin.tahun-akademik.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Mengambil data tahun akademik
        $tahun_akademik = TahunAkademik::findOrFail($id);

        // View
        return view('admin/tahun-akademik/edit', [
            'tahun_akademik' => $tahun_akademik
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
        // Validation
        $validator = Validator::make($request->all(), [
            'tahun' => 'required',
            'semester' => 'required',
            'status' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update data tahun akademik
            $tahun_akademik = TahunAkademik::find($request->id);
            $tahun_akademik->tahun = $request->tahun;
            $tahun_akademik->semester = $request->semester;
            $tahun_akademik->status = $request->status;
            $tahun_akademik->save();

            // Jika status aktif, maka otomatis mengganti tahun akademik lain menjadi tidak aktif
            if($tahun_akademik->status == 1) {
                $array = TahunAkademik::where('status','=',1)->where('id','!=',$tahun_akademik->id)->pluck('id')->toArray();
                if(count($array) > 0) {
                    foreach($array as $a) {
                        $taa = TahunAkademik::find($a);
                        $taa->status = 0;
                        $taa->save();
                    }
                }
            }

            // Redirect
            return redirect()->route('admin.tahun-akademik.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Mengambil data tahun akademik
        $tahun_akademik = TahunAkademik::find($request->id);

        // Menghapus data tahun akademik
        $tahun_akademik->delete();

        // Redirect
        return redirect()->route('admin.tahun-akademik.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
