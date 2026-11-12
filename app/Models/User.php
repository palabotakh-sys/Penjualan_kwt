<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;
    protected $fillable = ['name', 'email', 'password', 'phone_number', 'address', 'role'];
    protected $hidden = ['password', 'remember_token'];
    protected function casts(): array {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }
    public function isKetua(): bool { return $this->role === 'ketua'; }
    public function isBendahara(): bool { return $this->role === 'bendahara'; }
    public function isAnggota(): bool { return $this->role === 'anggota'; }
    public function isCustomer(): bool { return $this->role === 'customer'; }
    public function isAdmin(): bool { return in_array($this->role, ['ketua', 'bendahara', 'anggota']); }
    public function orders() { return $this->hasMany(Order::class); }
    public function cartItems() { return $this->hasMany(CartItem::class); }
    public function cashMutations() { return $this->hasMany(CashMutation::class, 'recorded_by'); }
    public function products() { return $this->hasMany(Product::class, 'created_by'); }
}
