<?php

namespace LaravelVueJs\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaravelVueJs\Traits\HasCategories;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Tags\HasTags;

class Post extends Model implements HasMedia
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
        'user_id',
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
        if (isset($args['sort_by'])) {
            switch ($args['sort_by']) {
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
        }

        if (isset($args['s'])) {
            $query->where('title', 'LIKE', '%' . $args['s'] . '%')
                ->orWhere('content', 'LIKE', '%' . $args['s'] . '%');
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

        if ($tag) {
            return $tag->posts()->where('status', 1)->getQuery();
        }

        abort(404);
    }

    public function postsByCategory($root, array $args, $context, ResolveInfo $resolveInfo): Builder
    {
        $category = Category::whereSlug($args['slug'])->first();

        if ($category) {
            return $category->posts()->where('status', 1)->getQuery();
        }

        abort(404);
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
}

