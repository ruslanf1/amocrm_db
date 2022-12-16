<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'contacts';

    public function leads() {
        return $this->belongsToMany(Lead::class);
    }
}
