<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title',
        'heading',
        'body',
        'start_date',
        'end_date',
        'announcement_image',
        'announcement_type',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'title',
                'heading',
                'body',
                'start_date',
                'end_date',
                'announcement_image',
                'announcement_type',
                'status',
            ])
            ->logOnlyDirty()
            ->useLogName('barangay_announcement');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName === 'created') {
            return 'Created an announcement';
        }
        elseif ($eventName === 'updated' && $this->getDirty()){
            return 'Edited an announcement';
        }
        elseif ($eventName === 'deleted'){
            return 'Deleted an announcement';
        }


        return ucfirst($eventName) . " an announcement";
    }


}
