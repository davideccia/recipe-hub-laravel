<?php

namespace App\Models;

use App\Models\Scopes\MeasurementUnitScope;
use App\Observers\MeasurementUnitObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(MeasurementUnitScope::class)]
#[ObservedBy(MeasurementUnitObserver::class)]
/**
 * @mixin IdeHelperMeasurementUnit
 */
class MeasurementUnit extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'label',
    ];
}
