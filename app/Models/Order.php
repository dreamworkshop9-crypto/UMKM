<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;
    protected $fillable = ['user_id','invoice','name','phone','address','city','postal_code','payment_method','total','status','notes','tracking_number'];
    public function user()  { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class); }
    public function getTotalFormattedAttribute()  { return 'Rp'.number_format($this->total,0,',','.'); }
    public function getStatusLabelAttribute() {
        return match($this->status) {
            'pending'=>'Menunggu Konfirmasi','confirmed'=>'Dikonfirmasi','processing'=>'Diproses',
            'shipped'=>'Dikirim','delivered'=>'Diterima','cancelled'=>'Dibatalkan',default=>'Unknown'
        };
    }
    public function getStatusColorAttribute() {
        return match($this->status) {
            'pending'=>'warning','confirmed'=>'info','processing'=>'primary',
            'shipped'=>'secondary','delivered'=>'success','cancelled'=>'danger',default=>'secondary'
        };
    }
}
