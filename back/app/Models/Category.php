<?php

namespace LaravelVueJs\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Collection as DbCollection;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use SortableTrait, HasSlug;

    public $guarded = [];

    public function scopeWithType(Builder $query, string $type = null): Builder
    {
        if (is_null($type)) {
            return $query;
        }

        return $query->where('type', $type)->orderBy('order_column');
    }

    /**
     * @param array|\ArrayAccess $values
     * @param string|null $type
     *
     * @return \LaravelVueJs\Models\Category|static
     */
    public static function findOrCreate($values, string $type = null)
    {
        $categories = collect($values)->map(function ($value) use ($type) {
            if ($value instanceof Category) {
                return $value;
            }

            return static::findOrCreateFromString($value, $type);
        });

        return is_string($values) ? $categories->first() : $categories;
    }

    public static function getWithType(string $type): DbCollection
    {
        return static::withType($type)->orderBy('order_column')->get();
    }

    public static function findFromString(string $name, string $type = null)
    {
        return static::query()
            ->where("name", $name)
            ->where('type', $type)
            ->first();
    }

    public static function findFromStringOfAnyType(string $name)
    {
        return static::query()
            ->where("name", $name)
            ->first();
    }

    protected static function findOrCreateFromString(string $name, string $type = null): self
    {

        $category = static::findFromString($name, $type);

        if (!$category) {
            $category = static::create([
                'name'        => $name,
                'description' => $name,
                'type'        => $type,
            ]);
        }

        return $category;
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}
