<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkOfficial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sk_official_image',
        'position',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'sk_official_image',
            ])
            ->logOnlyDirty()
            ->useLogName('sk_officials_list');
    }
    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName === 'updated' && $this->getDirty()){
            return 'Edited an SK official information';
        }

        return ucfirst($eventName) . " an announcement";
    }
}
