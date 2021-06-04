<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    // ค่าอะไรที่เพิ่มได้บ้าง
    protected $fillable = [
        'user',
        'department_name',
    ];

    // for join with Users table
    public function user(){
        return $this->hasOne(user::class,'id','user_id');
    }
}
