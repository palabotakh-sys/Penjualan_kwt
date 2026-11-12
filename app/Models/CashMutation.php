<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashMutation extends Model {
    use HasFactory;
    protected $fillable = ['order_id', 'transaction_type', 'amount', 'category', 'description', 'recorded_by', 'transaction_date'];
    protected $casts = ['amount' => 'decimal:2', 'transaction_date' => 'date'];
    public function order() { return $this->belongsTo(Order::class); }
    public function recorder() { return $this->belongsTo(User::class, 'recorded_by'); }
    public function getFormattedAmountAttribute(): string { return 'Rp ' . number_format($this->amount, 0, ',', '.'); }
    public function getCategoryLabelAttribute(): string {
        return match($this->category) {
            'penjualan_produk' => 'Penjualan Produk', 'iuran_anggota' => 'Iuran Anggota', 'operasional' => 'Biaya Operasional', default => $this->category
        };
    }
}
