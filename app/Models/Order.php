<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = [
        'user_id','voucher_id','order_number','status','subtotal',
        'discount','delivery_fee','total','delivery_address',
        'payment_method','payment_status','notes','delivery_lat','delivery_lng'
    ];

    public function user()     { return $this->belongsTo(User::class); }
    public function voucher()  { return $this->belongsTo(Voucher::class); }
    public function items()    { return $this->hasMany(OrderItem::class); }
    public function location() { return $this->hasOne(DeliveryLocation::class); }

    public function getStatusBadgeAttribute(): string {
        return match($this->status) {
            'pending'     => '<span class="badge badge-warning">Pending</span>',
            'confirmed'   => '<span class="badge badge-info">Confirmed</span>',
            'preparing'   => '<span class="badge badge-primary">Preparing</span>',
            'on_the_way'  => '<span class="badge badge-accent">On the Way</span>',
            'delivered'   => '<span class="badge badge-success">Delivered</span>',
            'cancelled'   => '<span class="badge badge-danger">Cancelled</span>',
            default       => '<span class="badge">Unknown</span>',
        };
    }

    public static function generateOrderNumber(): string {
        return 'FD-' . strtoupper(uniqid());
    }
}
