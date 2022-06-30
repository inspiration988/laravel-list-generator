<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListSetting extends Model
{
    use HasFactory;

    public $table = 'list_setting';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    public $fillable = [
        'name'
    ];


}
