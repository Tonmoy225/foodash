<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DeliveryLocation extends Model {
    public $timestamps = false;
    protected $fillable = ['order_id','lat','lng'];
    public function order() { return $this->belongsTo(Order::class); }
}
