<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer;

use RuntimeException;

class PropertyTypeWasNotDefined extends RuntimeException
{
    public function __construct($className, $propertyName)
    {
        parent::__construct(sprintf(
            'Property %s for class %s does not have a variable type defined.',
            $propertyName,
            $className
        ));
    }
}
