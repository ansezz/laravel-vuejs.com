<?php

namespace LaravelVueJs\Nova;


use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\TagsField\Tags;
use Ansezz\CategoriesField\Categories;

class Post extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'LaravelVueJs\\Models\\Post';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
        'content',
        'excerpt',
        'slug',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('User'),

            Text::make('Title')
                ->displayUsing(function ($title) {
                    return substr($title, 0, 50) . '...';
                })->sortable()
                ->rules('required'),

            Images::make('Image', \LaravelVueJs\Models\Post::MEDIA_COLLECTION)
                ->customPropertiesFields([
                    Text::make('Alt'),
                ]),

            Trix::make('Content')
                ->rules('required'),

            Textarea::make('Excerpt'),

            Select::make('Status')->options([
                1 => 'Publish',
                2 => 'Draft',
                3 => 'Trash',
                4 => 'Future',
            ]),


            Tags::make('Tags'),

            Boolean::make('Comment Status'),

            Categories::make('Categories'),

            Boolean::make('Featured'),

            Text::make('Source')->hideFromIndex(),

            Number::make('Views')->onlyOnIndex()->sortable(),


        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
