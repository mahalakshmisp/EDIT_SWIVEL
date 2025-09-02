<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'course_name',
        'author_name',
        'category_id',
        'video_path',
        'course_description',
        'author_description',
        'price',
    ];

    public function subscriptions()
    {
        return $this->hasMany(\App\Models\Subscription::class);
    }

    public function purchases()
    {
        return $this->hasMany(\App\Models\Purchase::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}
