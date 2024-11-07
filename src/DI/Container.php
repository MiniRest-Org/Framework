<?php

namespace MiniRestFramework\DI;

class Container {
    public array $instances = [];
    private array $bindings = [];

    /**
     * Associa uma interface ou alias a uma implementação específica.
     *
     * @param string $abstract
     * @param callable|string $concrete
     */
    public function bind(string $abstract, callable|string $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    /**
     * Registra um singleton no container.
     *
     * @param string $abstract
     * @param callable|string $concrete
     * @return mixed
     */
    public function singleton(string $abstract, callable|string $concrete): mixed
    {
        return $this->instances[$abstract] = is_callable($concrete) ? $concrete() : $concrete;
    }

    /**
     * Resolve uma instância do serviço solicitado.
     *
     * @param object|string $abstract A interface ou classe a ser resolvida.
     * @return mixed A instância resolvida.
     * @throws \Exception Se o serviço não for encontrado ou não puder ser instanciado.
     */
    public function make(mixed $abstract): mixed
    {
        $key = is_object($abstract) ? spl_object_hash($abstract) : $abstract;

        if (isset($this->instances[$key])) {
            return $this->instances[$key];
        }

        // Verifica se há um binding para essa interface/abstração
        if (isset($this->bindings[$abstract])) {
            $abstract = $this->bindings[$abstract];
        }

        if (is_string($abstract)) {

            if (class_exists('Facades\\'.$abstract)) {
                $this->instances[$abstract] = $abstract;
            }

            if (!class_exists($abstract)) {
                throw new \Exception("Class {$abstract} not found.");
            }

            $reflection = new \ReflectionClass($abstract);
        } elseif (is_object($abstract)) {
            $reflection = new \ReflectionClass($abstract);
        } else {
            throw new \Exception("Invalid type provided for make method.");
        }

        if (!$reflection->isInstantiable()) {
            throw new \Exception("Class {$abstract} cannot be instantiated.");
        }
        $constructor = $reflection->getConstructor();
        if (!$constructor) {
            return $reflection->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $param) {
            $dependencyClass = $param->getType()?->getName();

            if ($dependencyClass === 'array') continue;

            if ($dependencyClass) {
                $dependencies[] = $this->make($dependencyClass);
            } else {
                throw new \Exception("Unable to resolve dependency for parameter {$param->getName()} in class {$abstract}.");
            }
        }

        $instance = $reflection->newInstanceArgs($dependencies);

        // Armazena a instância apenas se for um singleton
        if (isset($this->instances[$key])) {
            $this->instances[$key] = $instance;
        }


        return $instance;
    }

    /**
     * Injeta dependências no método fornecido.
     *
     * @param object $instance A instância em que o método será chamado.
     * @param string $method O método a ser chamado.
     * @param array $parameters Parâmetros adicionais a serem injetados.
     * @return mixed O resultado do método chamado.
     * @throws \Exception Se não for possível resolver as dependências.
     */
    public function callMethod(object $instance, string $method, array $parameters = []): mixed
    {
        $reflection = new \ReflectionMethod($instance, $method);
        $dependencies = [];

        foreach ($reflection->getParameters() as $param) {
            $paramName = $param->getName();
            if (isset($parameters[$paramName])) {
                $dependencies[] = $parameters[$paramName];
            } elseif ($param->getType() && !$param->getType()->isBuiltin()) {
                $dependencies[] = $this->make($param->getType()->getName());
            } else {
                throw new \Exception("Unable to resolve dependency for parameter {$paramName} in method {$method}.");
            }
        }

        return $reflection->invokeArgs($instance, $dependencies);
    }

    /**
     * Obtém uma instância do serviço registrado.
     *
     * @param string $abstract Nome da classe ou interface.
     * @return mixed A instância do serviço.
     * @throws \Exception Se o serviço não estiver registrado.
     */
    public function get(string $abstract): mixed
    {
        return $this->make($abstract);
    }
}
