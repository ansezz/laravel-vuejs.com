<?php

namespace LaravelVueJs\Traits;

use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use LaravelVueJs\Models\Category;

trait HasCategories
{
    protected $queuedCategories = [];

    public static function getCategoryClassName(): string
    {
        return Category::class;
    }

    public static function bootHasCategories()
    {
        static::created(function (Model $categorizableModel) {
            $categorizableModel->attachCategories($categorizableModel->queuedCategories);

            $categorizableModel->queuedCategories = [];
        });

        static::deleted(function (Model $deletedModel) {
            $categories = $deletedModel->categories()->get();

            $deletedModel->detachCategories($categories);
        });
    }

    public function categories(): MorphToMany
    {
        return $this
            ->morphToMany(self::getCategoryClassName(), 'categorizable')
            ->orderBy('order_column');
    }

    /**
     * @param string|array|\ArrayAccess|Category $categories
     */
    public function setCategoriesAttribute($categories)
    {
        if (!$this->exists) {
            $this->queuedCategories = $categories;

            return;
        }

        $this->attachCategories($categories);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array|\ArrayAccess|Category $categories
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAllCategories(Builder $query, $categories, string $type = null): Builder
    {
        $categories = static::convertToCategories($categories, $type);

        collect($categories)->each(function ($category) use ($query) {
            $query->whereIn("{$this->getTable()}.{$this->getKeyName()}", function ($query) use ($category) {
                $query->from('categorizables')
                    ->select('categorizables.categorizable_id')
                    ->where('categorizables.category_id', $category ? $category->id : 0);
            });
        });

        return $query;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array|\ArrayAccess|Category $categories
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAnyCategories(Builder $query, $categories, string $type = null): Builder
    {
        $categories = static::convertToCategories($categories, $type);

        return $query->whereHas('categories', function (Builder $query) use ($categories) {
            $categoryIds = collect($categories)->pluck('id');

            $query->whereIn('categories.id', $categoryIds);
        });
    }

    public function scopeWithAllCategoriesOfAnyType(Builder $query, $categories): Builder
    {
        $categories = static::convertToCategoriesOfAnyType($categories);

        collect($categories)->each(function ($category) use ($query) {
            $query->whereIn("{$this->getTable()}.{$this->getKeyName()}", function ($query) use ($category) {
                $query->from('categorizables')
                    ->select('categorizables.categorizable_id')
                    ->where('categorizables.category_id', $category ? $category->id : 0);
            });
        });

        return $query;
    }

    public function scopeWithAnyCategoriesOfAnyType(Builder $query, $categories): Builder
    {
        $categories = static::convertToCategoriesOfAnyType($categories);

        return $query->whereHas('categories', function (Builder $query) use ($categories) {
            $categoryIds = collect($categories)->pluck('id');

            $query->whereIn('categories.id', $categoryIds);
        });
    }

    public function categoriesWithType(string $type = null): Collection
    {
        return $this->categories->filter(function (Category $category) use ($type) {
            return $category->type === $type;
        });
    }

    /**
     * @param array|\ArrayAccess|Category $categories
     *
     * @return $this
     */
    public function attachCategories($categories)
    {
        $className = static::getCategoryClassName();

        $categories = collect($className::findOrCreate($categories));

        $this->categories()->syncWithoutDetaching($categories->pluck('id')->toArray());

        return $this;
    }

    /**
     * @param string|Category $category
     *
     * @return $this
     */
    public function attachCategory($category)
    {
        return $this->attachCategories([$category]);
    }

    /**
     * @param array|\ArrayAccess $categories
     *
     * @return $this
     */
    public function detachCategories($categories)
    {
        $categories = static::convertToCategories($categories);

        collect($categories)
            ->filter()
            ->each(function (Category $category) {
                $this->categories()->detach($category);
            });

        return $this;
    }

    /**
     * @param string|Category $category
     *
     * @return $this
     */
    public function detachCategory($category)
    {
        return $this->detachCategories([$category]);
    }

    /**
     * @param array|\ArrayAccess $categories
     *
     * @return $this
     */
    public function syncCategories($categories)
    {
        $className = static::getCategoryClassName();

        $categories = collect($className::findOrCreate($categories));

        $this->categories()->sync($categories->pluck('id')->toArray());

        return $this;
    }

    /**
     * @param array|\ArrayAccess $categories
     * @param string|null $type
     *
     * @return $this
     */
    public function syncCategoriesWithType($categories, string $type = null)
    {
        $className = static::getCategoryClassName();

        $categories = collect($className::findOrCreate($categories, $type));

        $this->syncCategoryIds($categories->pluck('id')->toArray(), $type);

        return $this;
    }

    protected static function convertToCategories($values, $type = null, $locale = null)
    {
        return collect($values)->map(function ($value) use ($type, $locale) {
            if ($value instanceof Category) {
                if (isset($type) && $value->type != $type) {
                    throw new InvalidArgumentException("Type was set to {$type} but category is of type {$value->type}");
                }

                return $value;
            }

            $className = static::getCategoryClassName();

            return $className::findFromString($value, $type, $locale);
        });
    }

    protected static function convertToCategoriesOfAnyType($values, $locale = null)
    {
        return collect($values)->map(function ($value) use ($locale) {
            if ($value instanceof Category) {
                return $value;
            }

            $className = static::getCategoryClassName();

            return $className::findFromStringOfAnyType($value, $locale);
        });
    }

    /**
     * Use in place of eloquent's sync() method so that the category type may be optionally specified.
     *
     * @param $ids
     * @param string|null $type
     * @param bool $detaching
     */
    protected function syncCategoryIds($ids, string $type = null, $detaching = true)
    {
        $isUpdated = false;

        // Get a list of category_ids for all current categories
        $current = $this->categories()
            ->newPivotStatement()
            ->where('categorizable_id', $this->getKey())
            ->where('categorizable_type', self::class)
            ->when($type !== null, function ($query) use ($type) {
                $categoryModel = $this->categories()->getRelated();

                return $query->join(
                    $categoryModel->getTable(),
                    'categorizables.category_id',
                    '=',
                    $categoryModel->getTable() . '.' . $categoryModel->getKeyName()
                )
                    ->where('categories.type', $type);
            })
            ->pluck('category_id')
            ->all();

        // Compare to the list of ids given to find the categories to remove
        $detach = array_diff($current, $ids);
        if ($detaching && count($detach) > 0) {
            $this->categories()->detach($detach);
            $isUpdated = true;
        }

        // Attach any new ids
        $attach = array_diff($ids, $current);
        if (count($attach) > 0) {
            collect($attach)->each(function ($id) {
                $this->categories()->attach($id, []);
            });
            $isUpdated = true;
        }

        // Once we have finished attaching or detaching the records, we will see if we
        // have done any attaching or detaching, and if we have we will touch these
        // relationships if they are configured to touch on any database updates.
        if ($isUpdated) {
            $this->categories()->touchIfTouching();
        }
    }
}
