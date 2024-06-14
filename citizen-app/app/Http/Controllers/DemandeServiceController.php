<?php

namespace App\Http\Controllers;

use App\Models\DemandeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DemandeServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(DemandeService::with("demande")->get()->all());
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

        $user= Auth::user();
        $data= $request->data;
        
        $data["user_id"]= $user->id;
        $last= DemandeService::all()->last()->get();

        if($last->isNoEmpty){
            $data["code"]= $last->id +1;
        }
        else{
            $data["code"]= $last->id;
        }


        if(isset($data["code_path"])){
            $file_name= "/demande/code_". $data["code_recu"].".pdf";
            $data["code_path"]= Storage::put($file_name,$data["path"]);
        }



        $demande= new DemandeService($data);
        $demande->save();
        return response()->json(["message"=>"demande saved","data"=>$demande]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $demande= DemandeService::with("user")->find($id)->get();
        
        if($demande){
            return response()->json(["data"=>$demande]);
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

        
        $demande= DemandeService::find($id);
        
        if($demande){
            $data= $request->data;

            if(isset($data["code_path"])){
                $file_name= "/demande/code_". $data["code_recu"].".pdf";
                $data["code_path"]= Storage::put($file_name,$data["path"]);
            }

            $demande->update($data);
            $demande->save();
            return response()->json(["message"=>"demande updated","data"=>$demande]);
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
        $demande= DemandeService::find($id);
        
        if($demande){
            $demande->delete();
            return response()->json(["message"=>"demande deleted"]);
        }
        else{
            return response()->json(["error"=>"Not found"],404);
        }
    }
}

