<?php

namespace Core\Models\Meta;

use Core\Models\Term;

class TermMeta extends Meta
{
    /**
     * @var string
     */

    protected $table = 'termmeta';
    /**
     * @var array
     */
    protected $fillable = ['meta_key', 'meta_value', 'term_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}