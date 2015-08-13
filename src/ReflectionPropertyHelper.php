<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer;

class ReflectionPropertyHelper
{
    /**
     * @var \ReflectionClass
     */
    private $reflectionClass;

    /**
     * @var \ReflectionProperty
     */
    private $reflectionProperty;

    /**
     * @var array|null
     */
    private $types;

    /**
     * @var boolean|string
     */
    private $isObject = false;

    /**
     * @var boolean
     */
    private $isArray = false;

    public function __construct(\ReflectionClass $reflectionClass, \ReflectionProperty $reflectionProperty)
    {
        $reflectionProperty->setAccessible(true);


        if (strpos($reflectionProperty->getDocComment(), "@var") === false)
        {
            throw new PropertyTypeWasNotDefined($reflectionClass->getName(), $reflectionProperty->getName());
        }

        if (preg_match('/@var\s+([^\s]+)/', $reflectionProperty->getDocComment(), $matches)) {
            list(, $type) = $matches;
            $types = explode("|", $type);

            if (!empty($types)) {
                foreach ($types as $type) {
                    if (class_exists($type)) {
                        // Object
                        $this->types[] = $type;

                        $typeReflectionClass = new \ReflectionClass($type);
                        if (!$typeReflectionClass->isInterface() && !$typeReflectionClass->isAbstract()) {
                            $this->isObject = $type;
                        }

                    } else {
                        $typeCheck = $reflectionClass->getNamespaceName() . '\\' . $type;
                        if (class_exists($typeCheck)) {
                            // Object
                            $this->types[] = $typeCheck;

                            $typeReflectionClass = new \ReflectionClass($typeCheck);

                            if (!$typeReflectionClass->isInterface() && !$typeReflectionClass->isAbstract()) {
                                $this->isObject = $typeCheck;
                            }

                        } else {
                            $aliases = $this->getAliases($reflectionClass->getFileName());

                            if (array_key_exists($type, $aliases) && class_exists($aliases[$type])) {

                                $type = $aliases[$type];

                                // Object
                                $this->types[] = $type;

                                $typeReflectionClass = new \ReflectionClass($type);
                                if (!$typeReflectionClass->isInterface() && !$typeReflectionClass->isAbstract()) {
                                    $this->isObject = $type;
                                }

                            } else {
                                $this->types[] = $type = null;
                            }
                        }
                    }
                }
                array_unique($this->types);
            }
        }

        $this->reflectionClass = $reflectionClass;
        $this->reflectionProperty = $reflectionProperty;
    }

    public function isObject()
    {
        return ($this->isObject !== false);
    }

    public function isArray()
    {
        return in_array('array', $this->types);
    }

    public function getType()
    {
        return $this->isObject;
    }

    public function getValue($object)
    {
        return $this->reflectionProperty->getValue($object);
    }

    public function setValue($object, $value = null)
    {
        $this->reflectionProperty->setValue($object, $value);
    }

    public function getAliases($filename)
    {
        $source = file_get_contents($filename);
        $tokens = token_get_all($source);

        $uses = [];

        while (count($tokens)) {
            $token = array_shift($tokens);
            if (is_string($token)) {
                continue;
            }

            list($code, $value, $line) = $token;
            if ($code === T_USE) {
                $use = '';
                $alias = '';
                $as = false;
                while (count($tokens)) {
                    $next = array_shift($tokens);
                    if (is_string($next) && $next === ';') {
                        if ($alias != '') {
                            $key = $alias;
                        } else {
                            $key = explode("\\", $use);
                            $key = $key[count($key) - 1];
                        }
                        $uses[$key] = $use;
                        //$uses[$alias ?: $use] = $use;

                        continue 2;
                    }
                    list($code, $value, $line) = $next;
                    if ($code === T_WHITESPACE) {
                        continue;
                    }
                    if ($code === T_AS) {
                        $as = true;
                        continue;
                    }
                    if ($as) {
                        $alias .= $value;
                    } else {
                        $use .= $value;
                    }
                }
            }
        }

        return $uses;
    }
}
