<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\TaskList\Worker;

class Worker
{
    /**
     * @var WorkerId
     */
    private $workerId;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    public function __construct(WorkerId $workerId, $firstName, $lastName)
    {
        $this->workerId = $workerId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}