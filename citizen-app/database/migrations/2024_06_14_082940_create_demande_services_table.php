<?php

use App\Models\Service;
use App\Models\User;
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
        Schema::create('demande_services', function (Blueprint $table) {
            $table->id();
            $table->string("code_recu");
            $table->string("code_path")->nullable();
            $table->string("file_path")->nullable();
            $table->string("mode_payment")->nullable();

            $table->foreignIdFor(Service::class);
            $table->foreignIdFor(User::class);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_services');
    }
};
