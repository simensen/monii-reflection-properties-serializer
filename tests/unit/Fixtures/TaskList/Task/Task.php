<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\TaskList\Task;

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

    public function __construct(TaskId $taskId, WorkerId $workerId, $title)
    {
        $this->taskId = $taskId;
        $this->workerId = $workerId;
        $this->title = $title;
    }
}