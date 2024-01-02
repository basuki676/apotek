<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    // proprerty yang digunakan untuk menyimpan nama-nama colum yang kita bisa diisi valuenya
    // protected $fillabel = [
    //     'type',
    //     'name',
    //     'price',
    //     'stock',
    // ]; 
    
    protected $guarded = ['id'];
}
