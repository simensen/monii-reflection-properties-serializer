<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\TaskList\Common;

interface Identity
{
    public static function generate();

    public static function fromString($string);

    public static function equals(Identity $identity);

    public function __toString();
}