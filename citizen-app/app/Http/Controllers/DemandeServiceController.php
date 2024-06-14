<?php

namespace App\Http\Controllers;

use App\Models\DemandeService;
use Illuminate\Http\Request;

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
        $demande= new DemandeService($request->data);
        $demande->save();
        return response()->json(["message"=>"demande saved","data"=>$demande]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $demande= DemandeService::find($id);
        
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
            $demande->update($request->all());
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
