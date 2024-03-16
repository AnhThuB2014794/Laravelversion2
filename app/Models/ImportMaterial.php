<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportMaterial extends Model
{
    use HasFactory;
    protected $fillable = [
        'import_price',
        'product_id',
        'import_quantity',
        'import_date'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
