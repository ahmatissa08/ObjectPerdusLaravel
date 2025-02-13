<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    // Champs assignables en masse
    protected $fillable = [
        'title', 'description', 'type', 'location', 'image', 'found_date','category'
    ];

    // Relation avec l'utilisateur (si vous utilisez l'authentification)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
