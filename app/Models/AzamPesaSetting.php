<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AzamPesaSetting extends Model
{
    protected $table = 'azampesa_settings';

    protected $fillable = [
        'app_name',
        'client_id',
        'secret_id',
        'token',
        'mode',
    ];
}
