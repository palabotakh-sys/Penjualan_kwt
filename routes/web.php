<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController as FrontProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\OrderController as FrontOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CashMutationController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\QrisGatewayController;

// === GUEST ROUTES ===
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// === FRONTEND ROUTES (PUBLIC) ===
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [FrontProductController::class, 'index'])->name('products.index');
Route::get('/produk/{slug}', [FrontProductController::class, 'show'])->name('products.show');

// === FRONTEND ROUTES (AUTH CUSTOMER) ===
Route::middleware(['auth'])->group(function () {
    // Cart
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/keranjang/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{id}', [CartController::class, 'remove'])->name('cart.remove');
    // Orders
    Route::get('/checkout', [FrontOrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [FrontOrderController::class, 'store'])->name('orders.store');
    Route::get('/pesanan', [FrontOrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{orderCode}', [FrontOrderController::class, 'show'])->name('orders.show');
    Route::post('/pesanan/{orderCode}/bayar', [FrontOrderController::class, 'uploadPayment'])->name('orders.upload-payment');
});

// === ADMIN ROUTES ===
Route::middleware(['auth', 'role:ketua,bendahara,anggota'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('produk', ProductController::class);
    Route::resource('kategori', CategoryController::class);
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/pesanan/{order}/konfirmasi', [OrderController::class, 'confirm'])->name('orders.confirm');
    Route::patch('/pesanan/{order}/tolak', [OrderController::class, 'reject'])->name('orders.reject');
    Route::patch('/pesanan/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::resource('kas', CashMutationController::class)->middleware('role:ketua,bendahara');
    Route::resource('rekening', PaymentMethodController::class)->middleware('role:ketua,bendahara');
    Route::get('/qris-gateway', [QrisGatewayController::class, 'index'])->name('qris.index')->middleware('role:ketua,bendahara');
    Route::post('/qris-gateway', [QrisGatewayController::class, 'update'])->name('qris.update')->middleware('role:ketua,bendahara');
    Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/laporan/export', [ReportController::class, 'export'])->name('reports.export');
    Route::resource('pengguna', UserController::class)->middleware('role:ketua');
});
