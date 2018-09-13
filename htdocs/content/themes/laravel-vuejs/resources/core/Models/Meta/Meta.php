<?php

namespace Core\Models\Meta;

use Core\Models\BaseModel;
use Core\Models\Collection\MetaCollection;

/**
 * Class Meta
 * @package Core\Models\Meta
 */
abstract class Meta extends BaseModel
{
    /**
     * @var string
     */
    protected $primaryKey = 'meta_id';
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $appends = ['value'];

    /**
     * @return mixed
     */
    public function getValueAttribute()
    {
        try {
            $value = @unserialize($this->meta_value);
            return $value === false && $this->meta_value !== false ?
                $this->meta_value :
                $value;
        } catch (\Exception $ex) {
            return $this->meta_value;
        }
    }

    /**
     * @param array $models
     * @return MetaCollection
     */
    public function newCollection(array $models = [])
    {
        return new MetaCollection($models);
    }
}