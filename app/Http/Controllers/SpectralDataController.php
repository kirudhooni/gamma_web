<?php

namespace App\Http\Controllers;

use App\SpectralData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpectralDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function download($filename)
    {
	//	$headers = [
	//	'Content-Disposition': 'attachment;filename='.$filename.'.csv',
	//	];
		$path = storage_path().'/'.'files'.'/uploads/'.$filename.'.csv';
      return response()->download($path,$filename.'.csv',['Content-Description' =>  'File Transfer','Content-Type' => 'application/octet-stream','Content-Disposition' => 'attachment; filename='.$filename.'.csv']);
//	return $filename;
//	 return Response::download($path);
//	return $path;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'device_name' => 'required',
            'date_time' => 'required',
            'filename' => 'required',
            'user_id' => 'required',
            'data' => 'required',
        ]);

        $result = SpectralData::create($request->only('device_name', 'date_time', 'filename', 'user_id'));
        
       
     

        Storage::disk('uploads')->put($request->filename.'.csv', $request->data);
        
        return response()->json([
            "result_added" => true
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SpectralData  $spectralData
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
       
        $results = SpectralData::where('user_id', $id)->orderBy('created_at','desc')->get();
        return response()->json([
            "results" => $results
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SpectralData  $spectralData
     * @return \Illuminate\Http\Response
     */
    public function edit(SpectralData $spectralData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SpectralData  $spectralData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SpectralData $spectralData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SpectralData  $spectralData
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpectralData $spectralData)
    {
        //
    }
}
