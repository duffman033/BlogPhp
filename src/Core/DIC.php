<?php

namespace App\Core;

class DIC{

    private array $registry = [];
    private array $factories = [];
    private array $instances = [];

    public function set($key, Callable $resolver){
        $this->registry[$key] = $resolver;
    }

    public function setFactory($key, Callable $resolver){
        $this->factories[$key] = $resolver;
    }

    public function setInstance($instance){
        $reflection = new \ReflectionClass($instance);
        $this->instances[$reflection->getName()] = $instance;
    }

    public function get($key){
        if(isset($this->instances[$key])) {
            return($this->instances[$key]);
        }
        else {
            if(isset($this->registry[$key])) {
                $this->factories[$key] = $this->registry[$key]();
            }
            else {
                $reflected_class = new \ReflectionClass($key);
                if($reflected_class->isInstantiable()) {
                    $constructor = $reflected_class->getConstructor();
                    if($constructor) {
                        $parameters = $constructor->getParameters();
                        $constructor_parameters = [];
                        foreach($parameters as $parameter) {
                            if($parameter->getType()) {
                                $constructor_parameters[] = $this->getFactory($parameter->getType()->getName());
                            }
                            else {
                                $constructor_parameters[] = $parameter->getDefaultValue();
                            }
                        }
                        $this->factories[$key] = $reflected_class->newInstanceArgs($constructor_parameters);
                    }
                    else {
                        $this->factories[$key] = $reflected_class->newInstance();
                    }
                }
                else {
                    throw new Exception('"'.$key.'" is not an instantiable class');
                }
            }
        }
        return $this->factories[$key];
    }

}
