<?php

namespace LaravelVueJs\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Collection as DbCollection;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use SortableTrait, HasTranslations, HasSlug;

    public $translatable = ['name'];

    public $guarded = [];

    public function scopeWithType(Builder $query, string $type = null): Builder
    {
        if (is_null($type)) {
            return $query;
        }

        return $query->where('type', $type)->orderBy('order_column');
    }

    public function scopeContaining(Builder $query, string $name, $locale = null): Builder
    {
        $locale = $locale ?? app()->getLocale();

        $locale = '"' . $locale . '"';

        return $query->whereRaw("LOWER(JSON_EXTRACT(name, '$." . $locale . "')) like ?",
            ['"%' . strtolower($name) . '%"']);
    }

    /**
     * @param array|\ArrayAccess $values
     * @param string|null $type
     * @param string|null $locale
     *
     * @return \LaravelVueJs\Models\Category|static
     */
    public static function findOrCreate($values, string $type = null, string $locale = null)
    {
        $categories = collect($values)->map(function ($value) use ($type, $locale) {
            if ($value instanceof Category) {
                return $value;
            }

            return static::findOrCreateFromString($value, $type, $locale);
        });

        return is_string($values) ? $categories->first() : $categories;
    }

    public static function getWithType(string $type): DbCollection
    {
        return static::withType($type)->orderBy('order_column')->get();
    }

    public static function findFromString(string $name, string $type = null, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return static::query()
            ->where("name->{$locale}", $name)
            ->where('type', $type)
            ->first();
    }

    public static function findFromStringOfAnyType(string $name, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return static::query()
            ->where("name->{$locale}", $name)
            ->first();
    }

    protected static function findOrCreateFromString(string $name, string $type = null, string $locale = null): self
    {
        $locale = $locale ?? app()->getLocale();

        $category = static::findFromString($name, $type, $locale);

        if (!$category) {
            $category = static::create([
                'name'        => [$locale => $name],
                'description' => [$locale => $name . ' description '],
                'type'        => $type,
            ]);
        }

        return $category;
    }

    public function setAttribute($key, $value)
    {
        if ($key === 'name' && !is_array($value)) {
            return $this->setTranslation($key, app()->getLocale(), $value);
        }

        return parent::setAttribute($key, $value);
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
