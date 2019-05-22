<?php

namespace LaravelVueJs\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaravelVueJs\Traits\HasCategories;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Tags\HasTags;

/**
 * @method static whereSlug($slug)
 * @method static create(array $fields)
 */
class Post extends Model implements HasMedia, Feedable
{
    use HasSlug, HasMediaTrait, HasTags, HasCategories;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'slug',
        'type',
        'excerpt',
        'status',
        'featured',
        'comment_status',
        'source',
        'views',
        'user_id',
        'created_at',
        'updated_at',
    ];


    public const MEDIA_COLLECTION = 'image';


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(130);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION)->singleFile();
    }


    public function visible()
    {
        return $this->where('status', 1);
    }

    public function visiblePosts($root, array $args, $context, ResolveInfo $resolveInfo): Builder
    {
        /** @var Builder $query */
        $query = $this->visible();
        $sort_by = $args['sort_by'] ?? 'latest';
        switch ($sort_by) {
            case 'oldest':
                $query->oldest();
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        if (isset($args['s'])) {
            $query->where(function ($query) use ($args) {
                return $query->where('title', 'LIKE', '%' . $args['s'] . '%')
                    ->orWhere('content', 'LIKE', '%' . $args['s'] . '%');
            });
        }

        return $query;
    }

    public function featuredPosts($root, array $args, $context, ResolveInfo $resolveInfo): Builder
    {
        return $this->visible()->where('featured', 1)->latest();
    }

    public function postsByTag($root, array $args, $context, ResolveInfo $resolveInfo): Builder
    {
        $tag = Tag::findFromSlug($args['slug']);

        if (!$tag)
            abort(404);

        $query = $tag->posts()->where('status', 1)->getQuery();

        if (isset($args['s'])) {
            $query->where(function ($query) use ($args) {
                return $query->where('title', 'LIKE', '%' . $args['s'] . '%')
                    ->orWhere('content', 'LIKE', '%' . $args['s'] . '%');
            });
        }

        return $query;
    }

    public function postsByCategory($root, array $args, $context, ResolveInfo $resolveInfo): Builder
    {
        $category = Category::whereSlug($args['slug'])->first();

        if (!$category)
            abort(404);


        $query = $category->posts()->where('status', 1)->getQuery();

        if (isset($args['s'])) {
            $query->where(function ($query) use ($args) {
                return $query->where('title', 'LIKE', '%' . $args['s'] . '%')
                    ->orWhere('content', 'LIKE', '%' . $args['s'] . '%');
            });
        }

        return $query;
    }

    /**
     * Get the Post Image Url.
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        $media = $this->getFirstMedia(self::MEDIA_COLLECTION);

        return $media ? $media->getFullUrl() : '';
    }

    /**
     * Get the Post Url.
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return url($this->slug);
    }


    /**
     * Get the Post Url.
     *
     * @return string
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get the Post Url.
     *
     */
    public function getRelatedPostsAttribute()
    {
        $keywords = $this->categories->merge($this->tags)->pluck('name');
        $keywords = $keywords->merge(collect(explode('-', $this->slug)));

        return $this->where('status', 1)->where('id', '!=', $this->id)->where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere('title', 'like', '%' . $keyword . '%')
                    ->orWhere('content', 'like', '%' . $keyword . '%');
            }
        })->orderBy('views', 'desc')->limit(10)->get()->all();
    }

    /**
     * Get all of the posts for the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    /**
     * @return array|FeedItem
     */
    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->excerpt)
            ->updated($this->updated_at)
            ->link($this->url)
            ->author($this->user->name);
    }
}

