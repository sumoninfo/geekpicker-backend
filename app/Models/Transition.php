<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transition extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'from_user_id', 'to_user_id', 'from_currency', 'from_currency', 'amount'];
}
