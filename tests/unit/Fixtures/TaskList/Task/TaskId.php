<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\TaskList\Task;

use Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\TaskList\Common\Identity;
use Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\TaskList\Common\SimpleIdentity;

class TaskId implements Identity
{
    use SimpleIdentity;
}