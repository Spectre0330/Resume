<?php

namespace App\Models;

use App\Models\Concerns\Sortable;
use App\Models\Contracts\HasSortOrder;
use Database\Factories\SkillGroupFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property array<int, string> $skills
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['name', 'skills', 'sort_order'])]
class SkillGroup extends Model implements HasSortOrder
{
    /** @use HasFactory<SkillGroupFactory> */
    use HasFactory, Sortable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'skills' => 'array',
        ];
    }
}
