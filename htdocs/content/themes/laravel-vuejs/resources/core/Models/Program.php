<?php

namespace Core\Models;


class Program extends Post
{
    protected $postType = 'program';

    public function getImageSlideUrl()
    {
        $image = Attachment::find($this->meta->imageSlide);

        return (null === $image) ? null : $image->guid;
    }

}