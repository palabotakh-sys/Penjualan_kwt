<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model {
    use HasFactory;
    protected $fillable = ['order_code', 'user_id', 'payment_method_id', 'total_amount', 'shipping_address', 'customer_phone', 'customer_notes', 'payment_proof', 'payment_status', 'order_status', 'confirmed_by', 'confirmed_at'];
    protected $casts = ['total_amount' => 'decimal:2', 'confirmed_at' => 'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function paymentMethod() { return $this->belongsTo(PaymentMethod::class); }
    public function confirmedBy() { return $this->belongsTo(User::class, 'confirmed_by'); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
    public function cashMutation() { return $this->hasOne(CashMutation::class); }
    public function getFormattedTotalAttribute(): string { return 'Rp ' . number_format($this->total_amount, 0, ',', '.'); }
    public static function generateCode(): string {
        $prefix = 'TRX-' . date('Ymd') . '-';
        $last = static::where('order_code', 'like', $prefix . '%')->orderByDesc('id')->first();
        $num = $last ? (int) substr($last->order_code, -4) + 1 : 1;
        return $prefix . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
    public function getStatusBadgeAttribute(): string {
        return match($this->payment_status) {
            'paid' => 'green', 'pending' => 'yellow', 'rejected' => 'red', default => 'gray'
        };
    }
}
