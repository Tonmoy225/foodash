<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model {
    protected $fillable = ['code','discount_type','discount_value','min_order','max_uses','used_count','expires_at','is_active'];
    protected $casts = ['expires_at' => 'date'];

    public function isValid(float $orderTotal = 0): bool {
        if (!$this->is_active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->used_count >= $this->max_uses) return false;
        if ($orderTotal < $this->min_order) return false;
        return true;
    }

    public function calculateDiscount(float $total): float {
        if ($this->discount_type === 'percent') {
            return round($total * $this->discount_value / 100, 2);
        }
        return min($this->discount_value, $total);
    }
}
