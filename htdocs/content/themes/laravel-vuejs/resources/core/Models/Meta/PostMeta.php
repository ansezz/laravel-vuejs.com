<?php

namespace Core\Models\Meta;

use Core\Models\Post;

/**
 * Class PostMeta
 * @package Core\Models\Meta
 */
class PostMeta extends Meta
{
    /**
     * @var string
     */
    protected $table = 'postmeta';
    /**
     * @var array
     */
    protected $fillable = ['meta_key', 'meta_value', 'post_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}