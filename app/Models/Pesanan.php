<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'customer_name',
        'customer_phone',
        'items',
        'total_price',
        'status',
        'notes',
    ];

    protected $casts = [
        'items'      => 'array',
        'total_price' => 'integer',
        'status'     => 'string',
    ];

    public static function generateCode()
    {
        return 'ORD-' . str_pad(Pesanan::count() + 1, 5, '0', STR_PAD_LEFT);
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'masuk'           => ['text-emerald-400','bg-emerald-500/10','border-emerald-500/20'],
            'dikonfirmasi'      => ['text-blue-400','bg-blue-500/10','border-blue-500/20'],
            'dalam_perjalanan' => ['text-amber-400','bg-amber-500/10','border-amber-500/20'],
            'dikemas'         => ['text-purple-400','bg-purple-500/10','border-purple-500/20'],
            'dikirim'         => ['text-cyan-400','bg-cyan-500/10','border-cyan-500/20'],
            'selesai'         => ['text-slate-300','bg-slate-600/10','border-slate-600/20'],
            'dibatalkan'      => ['text-red-400','bg-red-500/10','border-red-500/20'],
        ];
        return $labels[$this->status] ?? ['text-slate-400','bg-slate-700/10','border-slate-700/20'];
    }

    public function getStatusDotColor()
    {
        $map = [
            'masuk'           => 'bg-emerald-400',
            'dikonfirmasi'      => 'bg-blue-400',
            'dalam_perjalanan' => 'bg-amber-400',
            'dikemas'         => 'bg-purple-400',
            'dikirim'         => 'bg-cyan-400',
            'selesai'         => 'bg-slate-400',
            'dibatalkan'      => 'bg-red-400',
        ];
        return $map[$this->status] ?? 'bg-slate-600';
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp' . number_format($this->total_price, 0, ',', '.');
    }

    public function getItemCountAttribute()
    {
        if (!$this->items) return 0;
        $items = is_array($this->items) ? $this->items : json_decode($this->items, true);
        return count($items);
    }
}
