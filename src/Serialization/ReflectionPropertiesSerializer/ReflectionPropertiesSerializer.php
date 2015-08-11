<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer;

class ReflectionPropertiesSerializer
{
    /**
     * @var ReflectionPropertiesSerializer
     */
    private $subSerializer;

    public function __construct(ReflectionPropertiesSerializer $subSerializer = null)
    {
        $this->subSerializer = $subSerializer;
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

            if ($property->isObject()) {
                $data[$reflectionProperty->getName()] = $this->subSerialize($property->getValue($object));
            } else {
                $data[$reflectionProperty->getName()] = $property->getValue($object);
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
                $property->setValue($object, $this->subDeserialize(
                    $property->getType(),
                    $data[$reflectionProperty->getName()]
                ));
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
        $this->ensureSubSerializerExists();

        return $this->subSerializer->serialize(
            $object
        );
    }

    private function subDeserialize($type, $data)
    {
        $this->ensureSubSerializerExists();

        return $this->subSerializer->deserialize(
            $type,
            $data
        );
    }

    private function ensureSubSerializerExists()
    {
        if (! is_null($this->subSerializer)) {
            return;
        }

        $this->subSerializer = new self();
    }
}
