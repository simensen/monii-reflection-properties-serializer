<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\Failing;

class NoTypehint
{
    private $noTypehint;

    public function __construct($noTypehint = null)
    {
        $this->noTypehint = $noTypehint;
    }
}