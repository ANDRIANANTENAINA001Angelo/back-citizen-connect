<?php  
namespace App; 

use App\Models\User;
use App\Models\DicCodeCopie;
use Exception;

class CodeCopie{

    static public function generateIdCode(string $code_copie, string $lieu_naissance){

        $code = "00";
        $dic = DicCodeCopie::where("lieu", "=", $lieu_naissance)->get();

        if ($dic->isEmpty()) {
            $last = DicCodeCopie::latest()->first();

            if ($last) {
                $lastId = $last->id + 1;
            } else {
                $lastId = 1; // Cas où il n'y a pas encore d'enregistrements dans la table
            }

            $newCode = $code . $lastId;
            $newDic = new DicCodeCopie(["lieu" => $lieu_naissance, "code" => $newCode]);
            $newDic->save();

            $code .= $newDic->id . $code_copie;
            return $code;
        } elseif ($dic->count() == 1) {
            $existingDic = $dic->first(); // Utilisez `first()` pour obtenir le premier (et unique) élément de la collection

            return $existingDic->code. $code_copie;
        } else {
            // Gestion des cas où il y aurait plus d'un résultat
            // Vous pouvez décider comment gérer ce cas
            throw new Exception("many code found with ".$lieu_naissance."!!!");
            // return "error";
        }


        
    }


}



?>