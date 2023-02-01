<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Perfil;
class UserMetadata extends Model
{
    use HasFactory;
    protected $guarded =[];
    public $timestamps = false;
    protected $table = 'user_metadata';
    
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }
}
