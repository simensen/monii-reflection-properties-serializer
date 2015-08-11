<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\Depth;

class ReflectionPropertiesSerializerExtended
{
    use ReflectionPropertiesSerializerTrait;

    private $privateExtendedValue;

    public function setPrivateExtendedValue($privateExtendedValue)
    {
        $this->privateExtendedValue = $privateExtendedValue;
    }
}