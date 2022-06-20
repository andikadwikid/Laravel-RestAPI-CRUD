<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriModel extends Model
{
    protected $table = 'kategoris';
    protected $fillable = ['nama'];

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
        return $this->hasMany(BarangModel::class);
    }
}
