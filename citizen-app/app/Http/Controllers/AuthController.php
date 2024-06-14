<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // public function Login(Request $request){
    //     $data=$request->all();
    //     $token="";
        
    //     $user= User::where("cin","=",$data["code"])->get();
    //     if($user->isEmpty()){
    //         $user= User::where("id_copie","=",$data["code"])->get();
    //         if($user->isEmpty()){
    //             return response()->json(["error"=>"user not found"]);
    //         }
    //         else{
    //             if(Hash::check($data["password"],$user[0]->password)){
    //                 return response()->json(["error"=>"password invalid"]);
    //             }
    //             else{
    //                 $token= $user[0]->createToken("token");
    //             }
    //         }
    //     }
    //     else{
    //         if(Hash::check($data["password"],$user[0]->password)){
    //             return response()->json(["error"=>"password invalid"]);
    //         }
    //         else{
    //             $token= $user[0]->createToken("token");
    //         }
    //     }

    //     $res=[
    //         "token"=>$token->plainTextToken,
    //         "id_user"=>$user[0]->id,
    //         "nom"=>$user[0]->nom,
    //         "prenom"=>$user[0]->prenom,
    //     ];

    //     return response()->json(["message"=>"user connected","data"=>$res]);
    // }


    public function Login(Request $request)
    {
        $data = $request->all();
        $token = "";

        // Rechercher l'utilisateur par CIN ou ID copie
        $user = User::where('cin', $data['code'])
                    ->orWhere('id_copie', $data['code'])
                    ->first();

        if (!$user) {
            return response()->json(["error" => "User not found"], 404);
        }

        if (!Hash::check($data['password'], $user->password)) {
            return response()->json(["error" => "Invalid password"], 401);
        }

        $token = $user->createToken("token")->plainTextToken;

        $res = [
            "token" => $token,
            "id_user" => $user->id,
            "nom" => $user->nom,
            "prenom" => $user->prenom,
        ];

        return response()->json(["message" => "User connected", "data" => $res]);
    }


    // public function LoginImage(Request $request)
    // {
    //     $data = $request->all();
    //     $token = "";


    //     // Rechercher l'utilisateur par CIN ou ID copie
    //     $user = User::where('cin', $data['code'])
    //                 ->orWhere('id_copie', $data['code'])
    //                 ->first();

    //     if (!$user) {
    //         return response()->json(["error" => "User not found"], 404);
    //     }

    //     // ici appel http://localhost:5000/correspondance
        
    //     // si il y a 
    //         $token = $user->createToken("token")->plainTextToken;

    //         $res = [
    //             "token" => $token,
    //             "id_user" => $user->id,
    //             "nom" => $user->nom,
    //             "prenom" => $user->prenom,
    //         ];

    //         return response()->json(["message" => "User connected", "data" => $res]);

    //     // si il n'y a pas
    //         // retourne message user non reconnue
    // }


    public function LoginImage(Request $request)
    {
        $data = $request->all();
        $token = "";

        // Rechercher l'utilisateur par CIN ou ID copie
        $user = User::where('cin', $data['code'])
                    ->orWhere('id_copie', $data['code'])
                    ->first();

        if (!$user) {
            return response()->json(["error" => "User not found"], 404);
        }

        $filepath= "/login/". $user->id. "_" . time()."jpg";
        $user_image_url = Storage::put($filepath, $data["image"]); 

        // URL de l'image à tester (fournie par la requête)
        $image_url_test = $user->photo_path;

        $client = new Client();
        $response = $client->post('http://localhost:5000/correspondance', [
            'json' => [
                'image_url_test' => $image_url_test,
                'image_url_compare' => $user_image_url
            ]
        ]);

        $body = json_decode($response->getBody(), true);

        if ($body['correspondance'] == 1) {
            $token = $user->createToken("token")->plainTextToken;

            $res = [
                "token" => $token,
                "id_user" => $user->id,
                "nom" => $user->nom,
                "prenom" => $user->prenom,
            ];

            return response()->json(["message" => "User connected", "data" => $res]);
        } else {
            return response()->json(["error" => "User not recognized"], 401);
        }
    }





    public function Logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json(
            ["message"=>"Utilisateur déconnecter"]
        );
    }


    
}
