<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TransaksiModel extends Model
{
    protected $table = 'barang_user';
    protected $guarded = [];
    protected $fillable = [
        'id',
        'kode_transaksi',
        'status',
        'bukti_bayar',
        'total_bayar',
        'qty',
        'user_id',
        'barang_id',
        'admin_id',

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

    public function barang()
    {
        return $this->belongsTo(BarangModel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
