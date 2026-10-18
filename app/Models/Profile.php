<?php

namespace App\Models;

use Database\Factories\ProfileFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $headline
 * @property string $bio
 * @property string $email
 * @property string|null $location
 * @property string|null $phone
 * @property bool $show_phone
 * @property string|null $github_url
 * @property string|null $linkedin_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['name', 'headline', 'bio', 'email', 'location', 'phone', 'show_phone', 'github_url', 'linkedin_url'])]
class Profile extends Model
{
    /** @use HasFactory<ProfileFactory> */
    use HasFactory;

    /**
     * Get the single resume profile, if one has been created.
     */
    public static function current(): ?self
    {
        return static::query()->first();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'show_phone' => 'boolean',
        ];
    }
}
