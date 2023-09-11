<?php declare(strict_types=1);

namespace Tests;

use LogicException;
use ReflectionObject;

trait PrivateTrait
{

    protected function getProperty(object $object, string $name): mixed
    {
        $reflection = new ReflectionObject($object);

        do {
            if ($reflection->hasProperty($name)) {
                $property = $reflection->getProperty($name);
                $property->setAccessible(TRUE);

                return $property->getValue($object);
            }

            $reflection = $reflection->getParentClass();
        } while ($reflection);

        throw new LogicException(sprintf("Property '%s' Not Found", $name));
    }

    protected function setProperty(object $object, string $name, mixed $value): void
    {
        $reflection = new ReflectionObject($object);

        do {
            if ($reflection->hasProperty($name)) {
                $property = $reflection->getProperty($name);
                $property->setAccessible(TRUE);
                $property->setValue($object, $value);

                return;
            }

            $reflection = $reflection->getParentClass();
        } while ($reflection);

        throw new LogicException(sprintf("Property '%s' Not Found", $name));
    }

    /**
     * @param mixed[] $parameters
     *
     * @throws LogicException
     */
    protected function invokeMethod(object $object, string $name, array $parameters = []): mixed
    {
        $reflection = new ReflectionObject($object);

        do {
            if ($reflection->hasMethod($name)) {
                $method = $reflection->getMethod($name);
                $method->setAccessible(TRUE);

                return $method->invokeArgs($object, $parameters);
            }

            $reflection = $reflection->getParentClass();
        } while ($reflection);

        throw new LogicException(sprintf("Method '%s' Not Found", $name));
    }

}
