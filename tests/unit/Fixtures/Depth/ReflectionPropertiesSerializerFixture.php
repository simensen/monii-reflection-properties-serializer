<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\Depth;

class ReflectionPropertiesSerializerFixture extends ReflectionPropertiesSerializerExtended
{
    /**
     * @var string
     */
    private $privateOuterValue;

    public function setPrivateOuterValue($privateOuterValue)
    {
        $this->privateOuterValue = $privateOuterValue;
    }
}