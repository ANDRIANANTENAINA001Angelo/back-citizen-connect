<?php

namespace App\Http\Controllers;

use App\Models\DicCodeCopie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

        if ($request->hasFile('photo_path')) {
            $photo_path = $request->file('photo_path');
            $fileName = 'photo_' . time() . '.' . $photo_path->getClientOriginalExtension();
            $filePath = $photo_path->storeAs('profile', $fileName, 'public');
            $data['photo_path'] = $filePath;
        }
        
        
        if($request->hasFile("cin_front_path")){
            $cin_front_path = $request->file("cin_front_path");
            $fileName = 'cin_front_' . time() . '.' . $cin_front_path->getClientOriginalExtension();
            $filePath = $cin_front_path->storeAs('cin', $fileName, 'public');
            $data["cin_front_path"] = $fileName;
        }

        if($request->hasFile("cin_back_path")){
            $cin_back_path = $request->file("cin_back_path");
            $fileName = 'cin_back_' . time() . '.' . $cin_back_path->getClientOriginalExtension();
            $filePath = $cin_back_path->storeAs('cin', $fileName, 'public');
            $data["cin_back_path"] = $fileName;
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

            // return response()->json(["photo_path"=>$data["photo_path"]]);

            if ($request->hasFile('photo_path')) {
                return response()->json("ok ok");
                $photo_path="";
                $photo_path = $request->file('photo_path');
                $fileName = 'photo_' . time() . '.' . $photo_path->getClientOriginalExtension();
                $filePath = $photo_path->storeAs('profile', $fileName, 'public');
                $data['photo_path'] = $filePath;
            }
            return response()->json("NOnnnnnnnn");
            
            
            if($request->hasFile("cin_front_path")){
                $cin_front_path = $request->file("cin_front_path");
                $fileName = 'cin_front_' . time() . '.' . $cin_front_path->getClientOriginalExtension();
                $filePath = $cin_front_path->storeAs('cin', $fileName, 'public');
                $data["cin_front_path"] = $fileName;
            }
    
            if($request->hasFile("cin_back_path")){
                $cin_back_path = $request->file("cin_back_path");
                $fileName = 'cin_back_' . time() . '.' . $cin_back_path->getClientOriginalExtension();
                $filePath = $cin_back_path->storeAs('cin', $fileName, 'public');
                $data["cin_back_path"] = $fileName;
            }

            $user->update($data);
            $user->save();
            return response()->json(["message"=>"user updated","data"=>$user]);
        }
        else{
            return response()->json(["error"=>"Not found"],404);
        }
    }

    public function uploads(Request $request, string $id){
        // Initialisation du chemin du fichier à null
        $filePath = null;
        $user=User::find($id);

        // Traitement du fichier s'il est présent
        if ($request->hasFile('photo_path')) {
            $file = $request->file('photo_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
            
            $user->photo_path= $filePath;
            $user->save();
            return response()->json([
                'photo_path' => $filePath,
            ], 200);
        }
        else{
            return response()->json([
                'err' =>"no file uploads",
            ], 400);

        }
        
    }


    public function uploads_cin(Request $request, string $id){
        // Initialisation du chemin du fichier à null
        $filePath = null;
        $user=User::find($id);

        // Traitement du fichier s'il est présent
        if ($request->hasFile('cin_front_path')) {
            $file = $request->file('cin_front_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
            $user->cin_front_path= $filePath;
            
        }
        else if($request->hasFile('cin_back_path')) {
            $file = $request->file('cin_back_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
            $user->cin_back_path= $filePath;
        }
        else{
            return response()->json([
                'err' =>"no file uploads",
            ], 400);

        }
        $user->save();
        return response()->json([
            'message' => "cin path saved",
        ], 200);
        
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
