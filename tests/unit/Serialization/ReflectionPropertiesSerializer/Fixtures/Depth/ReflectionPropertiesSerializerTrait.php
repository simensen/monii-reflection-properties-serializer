<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\Depth;

trait ReflectionPropertiesSerializerTrait
{
    private $privateTraitValue;
    public function setPrivateTraitValue($privateTraitValue)
    {
        $this->privateTraitValue = $privateTraitValue;
    }
}