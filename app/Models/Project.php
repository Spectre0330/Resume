<?php

namespace App\Models;

use App\Models\Concerns\Sortable;
use App\Models\Contracts\HasSortOrder;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property array<int, string> $tech
 * @property string|null $repo_url
 * @property string|null $live_url
 * @property bool $is_featured
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['title', 'description', 'tech', 'repo_url', 'live_url', 'is_featured', 'sort_order'])]
class Project extends Model implements HasSortOrder
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory, Sortable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tech' => 'array',
            'is_featured' => 'boolean',
        ];
    }
}
