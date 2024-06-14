<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Service::all());
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
        $service= new Service($request->data);
        $service->save();
        return response()->json(["message"=>"service saved","data"=>$service]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service= Service::find($id);
        
        if($service){
            return response()->json(["data"=>$service]);
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
        $service= Service::find($id);
        
        if($service){
            $service->update($request->all());
            $service->save();
            return response()->json(["message"=>"service updated","data"=>$service]);
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
        $service= Service::find($id);
        
        if($service){
            $service->delete();
            return response()->json(["message"=>"service deleted"]);
        }
        else{
            return response()->json(["error"=>"Not found"],404);
        }
    }
}
