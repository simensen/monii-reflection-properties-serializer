<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\TaskList\Common;

trait SimpleIdentity
{
    /**
     * @var string
     */
    private $value;

    public static function generate()
    {

    }

    public static function fromString($string)
    {
        return new self($string);
    }

    public static function equals(Identity $identity)
    {

    }

    public function __toString()
    {
        return (string) $this->value;
    }

}