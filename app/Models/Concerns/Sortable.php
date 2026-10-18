<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 */
trait Sortable
{
    /**
     * Give new records the next sort position when none is provided.
     */
    public static function bootSortable(): void
    {
        static::creating(function (self $model): void {
            if (! $model->sort_order) {
                $model->sort_order = (int) static::query()->max('sort_order') + 1;
            }
        });
    }

    /**
     * Scope the query to the admin-defined display order.
     *
     * @param  Builder<static>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Move the given record to a new zero-based position, shifting the others.
     */
    public static function moveTo(int $id, int $position): void
    {
        $ids = static::query()->ordered()->pluck('id')->reject(fn (int $existing): bool => $existing === $id)->values();

        $ids->splice($position, 0, [$id]);

        $ids->each(fn (int $orderedId, int $index) => static::query()->whereKey($orderedId)->update(['sort_order' => $index + 1]));
    }
}
