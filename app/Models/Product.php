<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Product extends Model {
    use HasFactory;
    protected $table = 'produks';
    protected $fillable = ['name','slug','description','price','old_price','stock','stok','harga','thumbnail','image','sku','weight','kategori_id','subcategory_id','subsubcategory_id','brand_id','is_active','is_new','is_best_seller'];
    protected $casts = ['is_active'=>'boolean','is_new'=>'boolean','is_best_seller'=>'boolean','price'=>'integer','old_price'=>'integer'];
 
    public function category()   { return $this->belongsTo(Category::class, 'kategori_id'); }
    public function brand()      { return $this->belongsTo(Brand::class); }
    public function images()     { return $this->hasMany(ProductImage::class); }
    public function variants()   { return $this->hasMany(ProductVariant::class); }
    public function cartItems()  { return $this->hasMany(Cart::class); }
    public function wishlists()  { return $this->hasMany(Wishlist::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
 
    public function getStokAttribute() {
        return $this->attributes['stock'] ?? $this->attributes['stok'] ?? 0;
    }

    public function setStokAttribute($value) {
        $this->attributes['stock'] = (int) $value;
    }

    public function getHargaAttribute() {
        return $this->attributes['price'] ?? $this->attributes['harga'] ?? 0;
    }

    public function setHargaAttribute($value) {
        $this->attributes['price'] = (int) $value;
    }

    public function getDiscountPercentAttribute() {
        if (!$this->old_price || $this->old_price <= $this->price) return 0;
        return round((($this->old_price - $this->price) / $this->old_price) * 100);
    }
    public function getThumbnailUrlAttribute() {
    $path = $this->thumbnail ?: $this->image;
    return $path ? '/storage/'.$path : 'https://via.placeholder.com/300x300?text=No+Image';
    }
    public function getPriceFormattedAttribute() { return 'Rp'.number_format($this->price,0,',','.'); }
    public function getOldPriceFormattedAttribute() { return $this->old_price ? 'Rp'.number_format($this->old_price,0,',','.') : null; }
}
