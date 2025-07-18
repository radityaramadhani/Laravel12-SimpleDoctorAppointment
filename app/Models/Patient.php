<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'name',
        'gender',
        'date_of_birth',
        'address',
        'phone_number',
        'NIK',
        'photo',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}


// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Patient extends Model
// {
//     protected $fillable = [
//         'name',
//         'gender',
//         'date_of_birth',
//         'address',
//         'phone_number',
//         'NIK',
//         'photo',
//     ];
// }

