<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model {
    use HasFactory;
    protected $fillable = ['category_id', 'code', 'name', 'slug', 'description', 'price', 'unit', 'stock', 'image', 'is_active', 'created_by'];
    protected $casts = ['price' => 'decimal:2', 'is_active' => 'boolean'];
    public function category() { return $this->belongsTo(Category::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function cartItems() { return $this->hasMany(CartItem::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
    public function getFormattedPriceAttribute(): string { return 'Rp ' . number_format($this->price, 0, ',', '.'); }
    public function isAvailable(): bool { return $this->is_active && $this->stock > 0; }
    public function getImageUrlAttribute(): string {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return asset('images/no-image.png');
    }
}
