<?php

namespace App\Core;

class DIC
{

    private array $registry = [];
    private array $factories = [];
    private array $instances = [];

    public function set($key, callable $resolver)
    {
        $this->registry[$key] = $resolver;
    }

    public function get($key)
    {
        if (isset($this->instances[$key])) {
            return ($this->instances[$key]);
        }
        if (isset($this->registry[$key])) {
            return ($this->factories[$key] = $this->registry[$key]());
        }
        $reflectedClass = new \ReflectionClass($key);
        if ($reflectedClass->isInstantiable()) {
            $constructor = $reflectedClass->getConstructor();
            if ($constructor) {
                $parameters = $constructor->getParameters();
                $constructParameters = [];
                foreach ($parameters as $parameter) {
                    if ($parameter->getType()) {
                        return ($constructParameters[] = $this->get($parameter->getType()->getName()));
                    }
                    $constructParameters[] = $parameter->getDefaultValue();
                }
                return ($this->factories[$key] = $reflectedClass->newInstanceArgs($constructParameters));
            }
            $this->factories[$key] = $reflectedClass->newInstance();
            return $this->factories[$key];
        }
        throw new \Exception('"' . $key . '" is not an instantiable class');
    }
}
