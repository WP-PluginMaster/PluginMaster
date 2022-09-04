<?php

namespace PluginMaster\Bootstrap\System;


use Exception;
use PluginMaster\Foundation\Resolver\CallbackResolver;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;

class DependencyInjectionContainer
{
    protected array $instances = [];

    /**
     * @param string $class
     * @param array $parameters
     * @return object
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function make(string $class, array $parameters = []): object
    {
        if ($this->instances[$class] ?? false) {
            return $this->instances[$class];
        }

        $classReflection = new ReflectionClass($class);
        $constructorParams = $classReflection->getConstructor() ? $classReflection->getConstructor()->getParameters(
        ) : [];

        return $this->instances[$class] = $classReflection->newInstance(
            ...$this->getClassDependencies($constructorParams, $parameters)
        );
    }

    /**
     * @param $callable
     * @param array $parameters
     * @return mixed
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function call($callable, array $parameters = [])
    {
        $resolvedCallable = CallbackResolver::resolve($callable);

        $classOrObject = $resolvedCallable[0];
        $method = $resolvedCallable[1];

        $object = is_object($classOrObject) ? $classOrObject : $this->make($classOrObject, $parameters);

        /** @var ReflectionMethod $methodReflection */
        list($methodReflection, $dependencies) = $this->getMethodDependency($object, $method, $parameters);

        return $methodReflection->invoke($object, ...$dependencies);
    }

    /**
     * initiate the class and return the instance.
     * @param string $id
     * @return object
     * @throws \ReflectionException
     */
    public function get(string $id): object
    {
        if (!isset($this->instances[$id])) {
            $this->instances[$id] = $this->make($id);
        }

        return $this->instances[$id];
    }

    /**
     * initiate the class and return the instance.
     * @param string $id
     * @return mixed|string
     */
    public function has(string $id): bool
    {
        if (!isset($this->instances[$id])) {
            return true;
        }

        return false;
    }

    /**
     * @param array $constructorParams
     * @param array $parameters
     * @return array
     * @throws \Exception
     */
    public function getClassDependencies(array $constructorParams, array $parameters): array
    {
        $dependencies = [];
        /**
         * loop with constructor parameters or dependencies
         */
        foreach ($constructorParams as $constructorParam) {
            $type = $constructorParam->getType();

            if ($type instanceof ReflectionNamedType) {
                $dependencies[] = $constructorParam->getClass()->newInstance();
            } else {
                $name = $constructorParam->getName();

                if (!empty($parameters) && array_key_exists($name, $parameters)) {
                    $dependencies[] = $parameters[$name];
                } else {
                    if (!$constructorParam->isOptional()) {
                        throw new Exception("Can not resolve parameters");
                    }
                }
            }
        }
        return $dependencies;
    }

    /**
     * @param object $object
     * @param string $method
     * @param array $parameters
     * @return array
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function getMethodDependency(object $object, string $method, array $parameters): array
    {
        $methodReflection = new ReflectionMethod($object, $method);
        $methodParams = $methodReflection->getParameters();
        $dependencies = [];

        foreach ($methodParams as $param) {
            $type = $param->getType();
            if ($type instanceof ReflectionNamedType) {
                $name = $param->getClass()->newInstance();
                $dependencies[] = $name;
            } else {
                $name = $param->getName();
                if (array_key_exists($name, $parameters)) {
                    $dependencies[] = $parameters[$name];
                } else {
                    if (!$param->isOptional()) {
                        throw new Exception("Can not resolve parameters");
                    }
                }
            }
        }

        return [$methodReflection, $dependencies];
    }
}