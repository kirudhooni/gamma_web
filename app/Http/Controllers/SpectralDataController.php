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
        //$path = storage_path().'\\'.'files'.'\\uploads\\'.$filename.'.csv';
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
        
        $command = escapeshellcmd(storage_path().'/'.'files'.'/uploads/generate.py -f '.$request->filename.'.csv');
        $output = shell_exec($command);
        
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

    public function showDetails($filename){

        $contents = Storage::disk('uploads')->get($filename.'.csv');
        $path = storage_path().'/'.'files'.'/uploads/'.$filename.'.csv';
        // $contents = Storage::get($filename.'.csv');
        
        $file = fopen($path, "r");
        $all_temperature = array();
        $all_time = array();
        $all_activity = array();
        $all_photopic = array();
        $all_mel = array();
        $all_lcone = array();
        $all_mcone = array();
        $all_scone = array();
        $all_rcone = array();
       
        $all_spd = array();
        $all_data = array();
        $count = 0;
        
        
        

        while ( ($data = fgetcsv($file)) !==FALSE ) {
            
            if ($count != 0){
                $spd = array();
                $time = $data[0];
                $temperature = $data[1];
                $activity = $data[2];
                $photopic = $data[3];
                $melanopic = $data[4];
                $erythropic = $data[5];
                $chloropic = $data[6];
                $cyanopic = $data[7];
                $rhodopic = $data[8];

                

                // for ($i =0; $i<401; $i++){
                //     array_push($spd, $data[$i + 9]);
                // }
                //$spd = $data[3];
                
                array_push($all_temperature, $temperature);
                array_push($all_time, $time);
                array_push($all_activity, $activity);
                array_push($all_photopic ,$photopic);
                array_push($all_mel, $melanopic);
                array_push($all_lcone,$erythropic);
                array_push($all_mcone,$chloropic);
                array_push($all_scone,$cyanopic);
                array_push($all_rcone, $erythropic);
                //array_push($all_spd, $spd);
                //$testvar = $data;
            }
            $count ++;
        }
        fclose($file);
        
        //var_dump($data);

        array_push($all_data, $all_time);
        array_push($all_data, $all_temperature);
        array_push($all_data, $all_activity);
        array_push($all_data, $all_photopic);
        array_push($all_data, $all_mel);
        array_push($all_data, $all_lcone);
        array_push($all_data, $all_mcone);
        array_push($all_data, $all_scone);
        array_push($all_data, $all_rcone);
        //array_push($all_data, $all_spd);

        return response()->json([
            "detailedData" => $all_data
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
