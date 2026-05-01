<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Product extends Model {
    use HasFactory;
    protected $table = 'produks';
    protected $fillable = ['name','slug','description','price','old_price','stock','thumbnail','sku','weight','category_id','subcategory_id','subsubcategory_id','brand_id','is_active','is_new','is_best_seller'];
    protected $casts = ['is_active'=>'boolean','is_new'=>'boolean','is_best_seller'=>'boolean','price'=>'integer','old_price'=>'integer'];
 
    public function category()   { return $this->belongsTo(Category::class); }
    public function brand()      { return $this->belongsTo(Brand::class); }
    public function images()     { return $this->hasMany(ProductImage::class); }
    public function variants()   { return $this->hasMany(ProductVariant::class); }
    public function cartItems()  { return $this->hasMany(Cart::class); }
    public function wishlists()  { return $this->hasMany(Wishlist::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
 
    public function getDiscountPercentAttribute() {
        if (!$this->old_price || $this->old_price <= $this->price) return 0;
        return round((($this->old_price - $this->price) / $this->old_price) * 100);
    }
    public function getThumbnailUrlAttribute() {
        return $this->thumbnail ? asset('storage/'.$this->thumbnail) : 'https://via.placeholder.com/300x300?text=No+Image';
    }
    public function getPriceFormattedAttribute() { return 'Rp'.number_format($this->price,0,',','.'); }
    public function getOldPriceFormattedAttribute() { return $this->old_price ? 'Rp'.number_format($this->old_price,0,',','.') : null; }
}
