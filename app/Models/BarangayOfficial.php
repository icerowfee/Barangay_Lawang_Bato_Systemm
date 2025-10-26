<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangayOfficial extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'barangay_official_image',
        'position',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'barangay_official_image',
            ])
            ->logOnlyDirty()
            ->useLogName('barangay_officials_list');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName === 'updated' && $this->getDirty()){
            return 'Edited a barangay official information';
        }


        return ucfirst($eventName) . " an announcement";
    }
}
