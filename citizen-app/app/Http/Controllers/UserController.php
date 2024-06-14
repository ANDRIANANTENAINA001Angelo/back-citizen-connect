<?php

namespace App\Http\Controllers;

use App\Models\DicCodeCopie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        $data= $request->all();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // return response()->json($data);

        if(isset($data["photo_path"])){
            $file_name="/profile/img_".time().".png"; 
            $data["photo_path"]= Storage::put($file_name,$request->data["photo_path"]);
        }


        if(isset($data["cin_front_path"])){
            $file_name="/image/cin/front_".time().".png"; 
            $data["cin_front_path"]= Storage::put($file_name,$request->data["photo_path"]);
        }

        if(isset($data["cin_back_path"])){
            $file_name="/image/cin/back_".time().".png"; 
            $data["cin_back_path"]= Storage::put($file_name,$request->data["photo_path"]);
        }


        if(isset($data["code_copie"])){
            $data["id_copie"]= DicCodeCopie::generateIdCode($data["code_copie"],$data["lieu_naissance"]);
        }

        $user= new User($data);
        $user->save();

        $token= $user->createToken("token");
        

        $res=[
            "token"=>$token->plainTextToken,
            "id_user"=>$user->id,
            "nom"=>$user->nom,
            "prenom"=>$user->prenom,
        ];
        return response()->json(["message"=>"user saved","data"=>$res]);
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
        $data= $request->all();
        if($user){

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            if(isset($data["photo_path"])){
                $file_name="/profile/img_".time().".png"; 
                $data["photo_path"]= Storage::put($file_name,$request->data["photo_path"]);
            }

            if(isset($data["cin_front_path"])){
                $file_name="/image/cin/front_".time().".png"; 
                $data["cin_front_path"]= Storage::put($file_name,$request->data["photo_path"]);
            }
            
            if(isset($data["cin_back_path"])){
                $file_name="/image/cin/back_".time().".png"; 
                $data["cin_back_path"]= Storage::put($file_name,$request->data["photo_path"]);
            }

            $user->update($data);
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
