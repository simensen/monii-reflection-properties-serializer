<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\TaskList\Worker;

use Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\TaskList\Common\Identity;
use Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\TaskList\Common\SimpleIdentity;

class WorkerId implements Identity
{
    use SimpleIdentity;
}