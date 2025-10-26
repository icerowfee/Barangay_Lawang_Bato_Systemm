<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneratedReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'path',
        'filters',
        'report_type',
        'reporter_type',
        'reporter_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'filename',
                'path',
                'filters',
                'report_type',
                'reporter_type',
                'reporter_id',
            ])
            ->logOnlyDirty()
            ->useLogName('generated_report');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName === 'created') {
            return 'Generated a report';
        }

        return ucfirst($eventName) . " a generated report";
    }

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class);
    }
}
