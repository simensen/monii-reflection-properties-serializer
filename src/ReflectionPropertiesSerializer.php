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

            $value = $property->getValue($object);

            if (is_null($value)) {
                continue;
            }

            if ($property->getType()) {
                $data[$reflectionProperty->getName()] = $this->subSerialize($value);
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
    public function deserialize($type, array $data)
    {
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
            if ($property->isObject()) {
                $value = !is_null($data[$reflectionProperty->getName()])
                    ? $this->subDeserialize($property->getType(), $data[$reflectionProperty->getName()])
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

    private function subSerialize($object)
    {
        if ($this->handler->canSerialize($object)) {
            return $this->handler->serialize($object);
        }

        return $this->serialize(
            $object
        );
    }

    private function subDeserialize($type, $data)
    {
        if ($this->handler->canDeserialize($type, $data)) {
            return $this->handler->deserialize($type, $data);
        }

        return $this->deserialize(
            $type,
            $data
        );
    }
}
