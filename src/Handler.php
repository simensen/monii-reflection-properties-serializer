<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer;

interface Handler
{
    /**
     * @param object $object
     *
     * @return bool
     */
    public function canSerialize($object);

    /**
     * @param object $object
     *
     * @return array
     */
    public function serialize($object);

    /**
     * @param object $type
     *
     * @return bool
     */
    public function canDeserialize($type);

    /**
     * @param object $type
     * @param array $data
     *
     * @return object
     */
    public function deserialize($type, array $data);
}