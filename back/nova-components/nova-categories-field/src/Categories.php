<?php

namespace Ansezz\CategoriesField;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use LaravelVueJs\Models\Category as CategoryModel;

class Categories extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-categories-field';

    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->multiple();
    }


    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('name'),
        ];
    }

    public function type(string $type)
    {
        return $this->withMeta(['type' => $type]);
    }

    public function multiple(bool $multiple = true)
    {
        $this->withMeta([
            'multiple'        => $multiple,
            'suggestionLimit' => 5,
        ]);

        if (!$this->meta['multiple']) {
            $this->doNotLimitSuggestions();
        }

        return $this;
    }

    public function single(bool $single = true)
    {
        $this->withMeta(['multiple' => !$single]);

        if (!$this->meta['multiple']) {
            $this->doNotLimitSuggestions();
        }

        return $this;
    }

    public function withoutSuggestions()
    {
        return $this->limitSuggestions(0);
    }

    public function limitSuggestions(int $maxNumberOfSuggestions)
    {
        return $this->withMeta(['suggestionLimit' => $maxNumberOfSuggestions]);
    }

    public function doNotLimitSuggestions()
    {
        return $this->limitSuggestions(9999);
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $requestValue = $request[$requestAttribute];
        $categoryNames = explode('-----', $requestValue);
        $categoryNames = array_filter($categoryNames);

        $class = get_class($model);

        $class::saved(function ($model) use ($categoryNames) {
            $model->syncCategoriesWithType($categoryNames, $this->meta()['type'] ?? null);
        });
    }

    public function resolveAttribute($resource, $attribute = null)
    {
        $categories = $resource->categories;

        if (array_has($this->meta(), 'type')) {
            $categories = $categories->where('type', $this->meta()['type']);
        }

        return $categories->map(function (CategoryModel $category) {
            return $category->name;
        })->values();
    }
}
