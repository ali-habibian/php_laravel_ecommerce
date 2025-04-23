<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Permission extends Model
{
    use HasRoles;
    
    protected $table = 'permissions';
    protected $guarded = [];
}
