<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerTime extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'adhan_time',
        'iqama_time',
        'effective_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'adhan_time' => 'datetime',
            'iqama_time' => 'datetime',
            'effective_date' => 'date',
        ];
    }

    public static function getTodayPrayers()
    {
        return self::where('effective_date', today())->get();
    }
}