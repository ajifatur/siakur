<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\KalenderAkademik;

class KalenderAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Mengambil data kalender akademik
        $kalender_akademik = KalenderAkademik::orderBy('id','desc')->get();

        // View
        return view('admin/kalender-akademik/index', [
            'kalender_akademik' => $kalender_akademik
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'start_datetime' => 'required',
            'end_datetime' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Simpan Kalender
            $kalender_akademik = new KalenderAkademik;
            $kalender_akademik->title = $request->title;
            $kalender_akademik->description = $request->description;
            $kalender_akademik->start_datetime = $request->start_datetime;
            $kalender_akademik->end_datetime = $request->end_datetime;
            $kalender_akademik->save();

            // Redirect
            return redirect()->route('admin.kalender-akademik.index')->with(['message' => 'Berhasil menambah data.']);;
        }
    }
}