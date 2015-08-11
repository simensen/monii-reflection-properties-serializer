<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\Depth;

class ReflectionPropertiesSerializerFixture extends ReflectionPropertiesSerializerExtended
{
    private $privateOuterValue;

    public function setPrivateOuterValue($privateOuterValue)
    {
        $this->privateOuterValue = $privateOuterValue;
    }
}