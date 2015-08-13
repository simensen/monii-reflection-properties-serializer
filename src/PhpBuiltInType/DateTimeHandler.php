<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\PhpBuiltInType;

use DateTime;
use DateTimeZone;
use Monii\Serialization\ReflectionPropertiesSerializer\Handler;

class DateTimeHandler implements Handler
{
    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $timezone;

    public function __construct($format = DateTime::ISO8601, $timezone = 'UTC')
    {
        $this->format = $format;
        $this->timezone = $timezone;
    }

    /**
     * (@inheritdoc)
     */
    public function canSerialize($object)
    {
        return $object instanceof DateTime;
    }

    /**
     * (@inheritdoc)
     */
    public function serialize($object)
    {
        return [
            'datetime' => $object->format($this->format),
            'timezone' => $object->getTimeZone()->getName(),
        ];
    }

    /**
     * (@inheritdoc)
     */
    public function canDeserialize($type)
    {
        # this might be too simplistic but will get us started
        return $type === DateTime::class;
    }

    /**
     * (@inheritdoc)
     */
    public function deserialize($type, array $data)
    {
        return DateTime::createFromFormat(
            $this->format,
            $data['datetime'],
            new DateTimeZone(array_key_exists('timezone', $data) ? $data['timezone'] : $this->timezone)
        );
    }
}
