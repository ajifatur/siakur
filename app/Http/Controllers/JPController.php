<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\JP;

class JPController extends Controller
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

        // Mengambil data JP
        $jp = JP::orderBy('hari','asc')->orderBy('jam_mulai','asc')->get();

        // View
        return view('admin/jp/index', [
            'jp' => $jp
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
        return view('admin/jp/create');
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
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan jam pelajaran
            $jp = new JP;
            $jp->hari = $request->hari;
            $jp->jam_mulai = $request->jam_mulai;
            $jp->jam_selesai = $request->jam_selesai;
            $jp->save();

            // Redirect
            return redirect()->route('admin.jp.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Mengambil data jam pelajaran
        $jp = JP::findOrFail($id);

        // View
        return view('admin/jp/edit', [
            'jp' => $jp
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
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update data jp
            $jp = JP::find($request->id);
            $jp->hari = $request->hari;
            $jp->jam_mulai = $request->jam_mulai;
            $jp->jam_selesai = $request->jam_selesai;
            $jp->save();

            // Redirect
            return redirect()->route('admin.jp.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Mengambil data jam pelajaran
        $jp = JP::find($request->id);

        // Menghapus data jam pelajaran
        $jp->delete();

        // Redirect
        return redirect()->route('admin.jp.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
