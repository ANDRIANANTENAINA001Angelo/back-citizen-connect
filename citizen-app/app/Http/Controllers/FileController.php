<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(File::with("user")->get()->all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data= $request->data;
        $file_name= "/". $data["type"]."/". $data["nom"]. time().".pdf";
        $data["path"]= Storage::put($file_name,$data["path"]);

        $file= new File($data);
        $file->save();
        return response()->json(["message"=>"file saved","data"=>$file]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $file= File::find($id);
        
        if($file){
            return response()->json(["data"=>$file]);
        }
        else{
            return response()->json(["error"=>"Not found"],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $file= File::find($id);
        
        if($file){
            $data= $request->data;
            $file_name= "/". $data["type"]."/". $data["nom"]. time().".pdf";
            $data["path"]= Storage::put($file_name,$data["path"]);

            $file->update($data);
            $file->save();
            return response()->json(["message"=>"file updated","data"=>$file]);
        }
        else{
            return response()->json(["error"=>"Not found"],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $file= File::find($id);
        
        if($file){
            $file->delete();
            return response()->json(["message"=>"file deleted"]);
        }
        else{
            return response()->json(["error"=>"Not found"],404);
        }
    }
}
