<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorUpload extends Model
{
    protected $fillable = [
        'vendor_id', 'title', 'description'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
