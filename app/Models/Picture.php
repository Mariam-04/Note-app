<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;
    protected $fillable = ['filename', 'path'];
    public function notes()
    {
    return $this->hasMany(Note::class, 'pic_id');
    }

}
