<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'leads';

    public function companies() {
        return $this->belongsTo(Company::class);
    }

    public function contacts() {
        return $this->belongsToMany(Contact::class);
    }
}
