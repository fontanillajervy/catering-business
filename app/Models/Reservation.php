<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'client_id',
        'package_id',
        'full_name',
        'contact_number',
        'email',
        'address',
        'event_type',
        'event_date',
        'event_time',
        'venue',
        'guest_count',
        'estimated_budget',
        'additional_services',
        'special_requests',
        'additional_notes',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
