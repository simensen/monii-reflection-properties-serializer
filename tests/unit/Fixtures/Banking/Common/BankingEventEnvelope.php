<?php

namespace Monii\AggregateEventStorage\Fixtures\Banking\Common;

use Monii\AggregateEventStorage\Aggregate\Support\ChangeReading\AggregateChangeReading;

class BankingEventEnvelope implements AggregateChangeReading
{
    public $event;
    public $metadata;
    public $eventId;
    public $version;

    private function __construct($eventId, $event, $metadata = null, $version = null)
    {
        $this->eventId = $eventId;
        $this->event = $event;
        $this->metadata = $metadata;
        $this->version = null;
    }

    public static function create($eventId, $event, $metadata = null)
    {
        return new self($eventId, $event, $metadata);
    }

    public static function instantiateAggregateChangeFromEventAndMetadata(
        $eventId,
        $event,
        $metadata = null,
        $version = null
    )
    {
        return new self($eventId, $event, $metadata, $version);
    }

    /**
     * @return object
     */
    public function getAggregateEvent()
    {
        return $this->event;
    }

    /**
     * @return object
     */
    public function getAggregateMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return object
     */
    public function getCanReadAggregateEventId()
    {
        return true;
    }

    /**
     * @return object
     */
    public function getAggregateEventId()
    {
        return $this->eventId;
    }

    /**
     * @return bool
     */
    public function getCanReadAggregateEventVersion()
    {
        return true;
    }

    /**
     * @return object
     */
    public function getAggregateEventVersion()
    {
        return $this->version;
    }
}
