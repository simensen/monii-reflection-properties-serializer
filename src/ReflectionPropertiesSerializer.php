<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer;

use Monii\Serialization\ReflectionPropertiesSerializer\PhpBuiltInType\PhpBuiltInTypeHandler;

class ReflectionPropertiesSerializer
{
    /**
     * @var ReflectionPropertiesSerializer
     */
    private $handler;

    public function __construct(Handler $handler = null)
    {
        $this->handler = $handler ?: new PhpBuiltInTypeHandler();
    }

    /**
     * (@inheritdoc)
     */
    public function serialize($object)
    {
        if ($this->handler->canSerialize($object)) {
            return $this->handler->serialize($object);
        }

        if (is_null($object)) {
            return null;
        }

        $data = [];

        $reflectionClass = new \ReflectionClass($object);

        $data = $this->addDataFromReflectionClass($data, $reflectionClass, $object);

        return $data;
    }

    private function addDataFromReflectionClass(
        array $data,
        \ReflectionClass $reflectionClass,
        $object
    ) {

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            if (array_key_exists($reflectionProperty->getName(), $data)) {
                continue;
            }

            $property = new ReflectionPropertyHelper($reflectionClass, $reflectionProperty);

            if ($property->isSkipped()) {
                continue;
            }

            $value = $property->getValue($object);

            if (is_null($value)) {
                continue;
            }

            if ($property->isArray() && $property->isObject()) {
                $data[$reflectionProperty->getName()] = array_map(function ($value) {
                    return $this->serialize($value);
                }, $value);
            } elseif ($property->getType()) {
                $data[$reflectionProperty->getName()] = $this->serialize($value);
            } else {
                $data[$reflectionProperty->getName()] = $value;
            }
        }

        if (false !== $parentClass = $reflectionClass->getParentClass()) {
            $data = $this->addDataFromReflectionClass($data, $parentClass, $object);
        }

        foreach ($reflectionClass->getTraits() as $traitReflectionClass) {
            $data = $this->addDataFromReflectionClass($data, $traitReflectionClass, $object);
        }

        return $data;
    }

    /**
     * (@inheritdoc)
     */
    public function deserialize($type, array $data = null)
    {
        if (is_null($data)) {
            return null;
        }

        if ($data instanceof \ArrayObject) {
            $data = $data->getArrayCopy();
        }

        if (is_object($type)) {
            $type = get_class($type);
        }

        if ($this->handler->canDeserialize($type)) {
            return $this->handler->deserialize($type, $data);
        }

        $reflectionClass = new \ReflectionClass($type);

        $object = $reflectionClass->newInstanceWithoutConstructor();

        $object = $this->setReflectionPropertiesFromData($data, $reflectionClass, $object);

        return $object;
    }

    private function setReflectionPropertiesFromData(
        array $data,
        \ReflectionClass $reflectionClass,
        $object
    ) {
        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            if (! array_key_exists($reflectionProperty->getName(), $data)) {
                continue;
            }

            $property = new ReflectionPropertyHelper($reflectionClass, $reflectionProperty);

            if ($property->isSkipped()) {
                continue;
            }

            if ($property->isArray() && $property->isObject()) {
                $values = array_map(function ($value) use ($property) {
                    if ($value instanceof \ArrayObject) {
                        $value = $value->getArrayCopy();
                    }
                    return $this->deserialize($property->getType(), $value);
                }, $data[$reflectionProperty->getName()]);
                $property->setValue($object, $values);
            } elseif ($property->isObject()) {
                $value = !is_null($data[$reflectionProperty->getName()])
                    ? $this->deserialize($property->getType(), $data[$reflectionProperty->getName()])
                    : null;

                $property->setValue(
                    $object,
                    $value
                );
            } else {
                $property->setValue($object, $data[$reflectionProperty->getName()]);
            }

            unset($data[$reflectionProperty->getName()]);
        }

        if (false !== $parentClass = $reflectionClass->getParentClass()) {
            $object = $this->setReflectionPropertiesFromData($data, $parentClass, $object);
        }

        foreach ($reflectionClass->getTraits() as $traitReflectionClass) {
            $object = $this->setReflectionPropertiesFromData($data, $traitReflectionClass, $object);
        }

        return $object;
    }
}
