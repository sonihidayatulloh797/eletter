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

    public function disposisis()
    {
        return $this->hasMany(Disposisi::class, 'surat_masuk_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function creatorRole()
    {
        return $this->belongsTo(Role::class, 'created_role_id');
    }

    public function updaterRole()
    {
        return $this->belongsTo(Role::class, 'updated_role_id');
    }
}
