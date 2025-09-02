<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_name',
        'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
