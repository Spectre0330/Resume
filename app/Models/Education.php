<?php

namespace App\Models;

use App\Models\Concerns\Sortable;
use App\Models\Contracts\HasSortOrder;
use Database\Factories\EducationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $institution
 * @property string $credential
 * @property Carbon $started_on
 * @property Carbon|null $ended_on
 * @property array<int, string> $details
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['institution', 'credential', 'started_on', 'ended_on', 'details', 'sort_order'])]
class Education extends Model implements HasSortOrder
{
    /** @use HasFactory<EducationFactory> */
    use HasFactory, Sortable;

    /**
     * Get the human readable year range, e.g. "2020 — 2024".
     */
    public function period(): string
    {
        return $this->started_on->format('Y').' — '.($this->ended_on?->format('Y') ?? 'Present');
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
            'details' => 'array',
        ];
    }
}
