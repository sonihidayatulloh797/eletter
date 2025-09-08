<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateSurat extends Model
{
    protected $table = 'template_surat';
    protected $fillable = [
        'nama_template',
        'kategori',
        'file_template'
    ];
}
