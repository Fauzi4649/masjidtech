<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'event_time',
        'location',
        'max_participants',
        'category',
        'admin_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'event_time' => 'datetime',
        ];
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function media()
    {
        return $this->hasMany(MediaUpload::class);
    }

    public function getRemainingSpotsAttribute()
    {
        return $this->max_participants - $this->registrations()->count();
    }

    public function isFull()
    {
        return $this->remaining_spots <= 0;
    }
}