<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\PhpBuiltInType;

use DateTimeImmutable;
use DateTimeZone;
use Monii\Serialization\ReflectionPropertiesSerializer\Handler;

class ImmutableDateTimeHandler implements Handler
{
    public function __construct($format = 'Y-m-d H:i:s.u', $timezone = 'UTC')
    {
        $this->format = $format;
        $this->timezone = $timezone;
    }

    public function canSerialize($object)
    {
        return $object instanceof DateTimeImmutable;
    }

    public function serialize($object)
    {
        return [
            'datetime' => $object->format($this->format),
            'timezone' => $object->getTimeZone()->getName(),
        ];
    }

    public function canDeserialize($type)
    {
        # this might be too simplistic but will get us started
        return $type === DateTimeImmutable::class;
    }

    public function deserialize($type, array $data)
    {
        return DateTimeImmutable::createFromFormat(
            $this->format,
            $data['datetime'],
            new DateTimeZone(array_key_exists('timezone', $data) ? $data['timezone'] : $this->timezone)
        );
    }
}
