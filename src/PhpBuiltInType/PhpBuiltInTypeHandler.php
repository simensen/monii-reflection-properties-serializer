<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\PhpBuiltInType;

use DateTime;
use DateTimeImmutable;
use Monii\Serialization\ReflectionPropertiesSerializer\Handler;
use Monii\Serialization\ReflectionPropertiesSerializer\HandlerChain;

class PhpBuiltInTypeHandler implements Handler
{
    /**
     * @var HandlerChain
     */
    private $handler;

    public function __construct()
    {
        $this->handler = new HandlerChain([
            new DateTimeHandler(),
            new ImmutableDateTimeHandler(),
        ]);
    }

    /**
     * (@inheritdoc)
     */
    public function canSerialize($object)
    {
        return $this->handler->canSerialize($object);
    }

    /**
     * (@inheritdoc)
     */
    public function serialize($object)
    {
        return $this->handler->serialize($object);
    }

    /**
     * (@inheritdoc)
     */
    public function canDeserialize($type)
    {
        return $this->handler->canDeserialize($type);
    }

    /**
     * (@inheritdoc)
     */
    public function deserialize($type, array $data)
    {
        return $this->handler->deserialize($type, $data);
    }

}