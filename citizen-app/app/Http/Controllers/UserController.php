<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(User::with(["Files","DemandeServices"])->get()->all());
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
        $user= new User($request->data);
        $user->save();
        return response()->json(["message"=>"user saved","data"=>$user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user= User::find($id);
        
        if($user){
            return response()->json(["data"=>$user]);
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
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        @/** @var User $user description */        
        $user= User::find($id);
        
        if($user){
            $user->update($request->all());
            $user->save();
            return response()->json(["message"=>"user updated","data"=>$user]);
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
        $user= User::find($id);
        
        if($user){
            $user->delete();
            return response()->json(["message"=>"user deleted"]);
        }
        else{
            return response()->json(["error"=>"Not found"],404);
        }
    }
}
