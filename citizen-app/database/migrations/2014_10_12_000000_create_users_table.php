<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // sing up (required)
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('adresse');
            $table->string('cin')->unique()->nullable();
            $table->string('code_copie')->nullable();
            $table->string('id_copie')->unique();
            $table->string('photo_path')->nullable();
            $table->string('face_info')->nullable();//for face reconization
            $table->string('password');
            
            // update in profile
            $table->string('profession')->nullable();
            $table->string('statut')->nullable();
            $table->string('district')->nullable();
            $table->string('nom_pere')->nullable();
            $table->string('prenom_pere')->nullable();
            $table->string('nom_mere')->nullable();
            $table->string('prenom_mere')->nullable();
            $table->string('nom_conjoint')->nullable();
            $table->string('prenom_conjoint')->nullable();

            // Laravel attribute (token, date)
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
