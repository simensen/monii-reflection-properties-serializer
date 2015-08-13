<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\Depth;

trait ReflectionPropertiesSerializerTrait
{
    /**
     * @var string
     */
    private $privateTraitValue;

    public function setPrivateTraitValue($privateTraitValue)
    {
        $this->privateTraitValue = $privateTraitValue;
    }
}