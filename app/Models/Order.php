<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medicines',
        'name_customer',
        'total_price',
    ];

    // penegasan tipe data dari migration (hasil proprti ini ketika diambil atau diinsert/update dibuat dalam bentuk tipr data apa)
    protected $casts = [
        'medicines' => 'array',
    ];

    public function user()
    {
        //menghubungkan ke primary keynya 
        //dalam kurung merupakan nama model tempat penyimpan dari PK nya si FK yang ada di model ini
        return $this->belongsTo(User::class);
    }
}
