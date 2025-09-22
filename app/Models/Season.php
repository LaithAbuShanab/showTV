<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'show_id',
        'title',
        'season_number',
    ];

    public function show()
    {
        return $this->belongsTo(Show::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
}
