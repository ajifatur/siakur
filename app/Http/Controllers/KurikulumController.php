<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Kurikulum;

class KurikulumController extends Controller
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

        // Mengambil data kurikulum
        $kurikulum = Kurikulum::orderBy('status','desc')->get();

        // View
        return view('admin/kurikulum/index', [
            'kurikulum' => $kurikulum
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
        return view('admin/kurikulum/create');
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
            'nama' => 'required',
            'status' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan kurikulum
            $kurikulum = new Kurikulum;
            $kurikulum->nama = $request->nama;
            $kurikulum->status = $request->status;
            $kurikulum->save();

            // Jika status aktif, maka otomatis mengganti kurikulum lain menjadi tidak aktif
            if($kurikulum->status == 1) {
                $array = Kurikulum::where('status','=',1)->where('id','!=',$kurikulum->id)->pluck('id')->toArray();
                if(count($array) > 0) {
                    foreach($array as $a) {
                        $taa = Kurikulum::find($a);
                        $taa->status = 0;
                        $taa->save();
                    }
                }
            }

            // Redirect
            return redirect()->route('admin.kurikulum.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Mengambil data kurikulum
        $kurikulum = Kurikulum::findOrFail($id);

        // View
        return view('admin/kurikulum/edit', [
            'kurikulum' => $kurikulum
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
            'nama' => 'required',
            'status' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update data kurikulum
            $kurikulum = Kurikulum::find($request->id);
            $kurikulum->nama = $request->nama;
            $kurikulum->status = $request->status;
            $kurikulum->save();

            // Jika status aktif, maka otomatis mengganti kurikulum lain menjadi tidak aktif
            if($kurikulum->status == 1) {
                $array = Kurikulum::where('status','=',1)->where('id','!=',$kurikulum->id)->pluck('id')->toArray();
                if(count($array) > 0) {
                    foreach($array as $a) {
                        $taa = Kurikulum::find($a);
                        $taa->status = 0;
                        $taa->save();
                    }
                }
            }

            // Redirect
            return redirect()->route('admin.kurikulum.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Mengambil data kurikulum
        $kurikulum = Kurikulum::find($request->id);

        // Menghapus data kurikulum
        $kurikulum->delete();

        // Redirect
        return redirect()->route('admin.kurikulum.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
