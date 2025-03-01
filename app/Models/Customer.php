<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer'; // Ensure it matches your actual database table

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'age',
        'dob',
        'creation_date',
    ];

    public $timestamps = false; // Since `customer` table uses `creation_date` instead of `created_at`
}
