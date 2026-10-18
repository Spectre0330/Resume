<?php

namespace App\Models;

use App\Models\Concerns\Sortable;
use App\Models\Contracts\HasSortOrder;
use Database\Factories\ExperienceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $company
 * @property string $role
 * @property string|null $location
 * @property Carbon $started_on
 * @property Carbon|null $ended_on
 * @property array<int, string> $bullets
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['company', 'role', 'location', 'started_on', 'ended_on', 'bullets', 'sort_order'])]
class Experience extends Model implements HasSortOrder
{
    /** @use HasFactory<ExperienceFactory> */
    use HasFactory, Sortable;

    /**
     * Get the human readable date range, e.g. "Jun 2024 — Present".
     */
    public function period(): string
    {
        return $this->started_on->format('M Y').' — '.($this->ended_on?->format('M Y') ?? 'Present');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'started_on' => 'date',
            'ended_on' => 'date',
            'bullets' => 'array',
        ];
    }
}
