<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeService extends Model
{
    use HasFactory;

    protected $fillable= [
        "code_recu",
        "code_path",
        "file_path",
        "mode_payment",
        "service_id", // à vérifier
        "user_id" // à vérifier
    ];

    /**
     * Get the user that owns the DemandeService
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Service that owns the DemandeService
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }


}
