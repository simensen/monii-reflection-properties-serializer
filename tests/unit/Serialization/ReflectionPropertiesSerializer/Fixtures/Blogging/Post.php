<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\Blogging;

class Post
{
    /**
     * @var PostId
     */
    private $postId;

    public function __construct(PostId $postId)
    {
        $this->postId = $postId;
    }
}
