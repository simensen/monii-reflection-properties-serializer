<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\TaskList\Task;

use DateTimeImmutable;
use Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\TaskList\Worker\WorkerId;

class Task
{
    /**
     * @var TaskId
     */
    private $taskId;

    /**
     * @var WorkerId
     */
    private $workerId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var DateTime|null
     */
    private $due;

    public function __construct(TaskId $taskId, WorkerId $workerId, $title, $due = null)
    {
        $this->taskId = $taskId;
        $this->workerId = $workerId;
        $this->title = $title;
        $this->due = $due;
    }
}