<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';
    protected $fillable = [
        'no_surat',
        'unit_pengirim',
        'unit_penerima',
        'perihal',
        'deskripsi',
        'tanggal',
        'tembusan',
        'file_surat',
        'user_id',
    ];

    public function disposisi()
    {
        return $this->hasMany(Disposisi::class, 'surat_masuk_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
