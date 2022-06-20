<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BarangModel extends Model
{
    protected $table = 'barangs';
    protected $fillable = [
        'kode',
        'gambar',
        'nama_brg',
        'harga',
        'stok',
        'deskripsi',
        'penulis',
        'penerbit',
        'tanggal',
        'kategori_id'
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
