<?php

namespace MiniRestFramework\Tests\DI;

use MiniRestFramework\DI\Container;
use MiniRestFramework\Http\Request\Request;
use MiniRestFramework\Tests\Examples\Objects\ExampleAction;
use MiniRestFramework\Tests\Examples\Objects\ExampleRepository;
use MiniRestFramework\Tests\Examples\Objects\ExampleService;
use MiniRestFramework\Tests\Examples\Objects\NonInstantiableClass;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{

    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
    }

    public function testAutoResolving() {

        // Exemplo de classe que deve ser resolvida automaticamente
        $exampleController = $this->container->make(ExampleAction::class);
        $exampleService = $this->container->make(ExampleService::class);

        $this->assertInstanceOf(ExampleAction::class, $exampleController);
        $this->assertInstanceOf(ExampleService::class, $exampleService);
        $this->assertInstanceOf(ExampleService::class, $exampleController->getService());
        $this->assertInstanceOf(ExampleService::class, $exampleController->getTestService());
        $this->assertInstanceOf(ExampleService::class, $exampleController->getTestService());
        $this->assertInstanceOf(ExampleRepository::class, $exampleService->getRepository());
    }

    public function testExampleServiceIsResolved()
    {
        $service = $this->container->make(ExampleService::class);
        $this->assertInstanceOf(ExampleService::class, $service);
        $this->assertEquals("Hello from ExampleService!", $service->sayHello());
    }

    public function testClassNotExistsException()
    {

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Class \MiniRestFramework\Tests\Objects\ExampleService1 not found.');

        $service = $this->container->make('\MiniRestFramework\Tests\Objects\ExampleService1');
        $this->assertNotInstanceOf(ExampleService::class, $service);

    }


    public function testStringClassDoesNotExist()
    {
        $className = 'NonExistentClass';
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Class {$className} not found.");

        $this->container->make($className);
    }

    public function testExampleActionIsResolved()
    {
        $controller = $this->container->make(ExampleAction::class);
        $this->assertInstanceOf(ExampleAction::class, $controller);
        $this->assertInstanceOf(ExampleService::class, $controller->getService());
    }

    public function testControllerIndexMethod()
    {
        $controller = $this->container->make(ExampleAction::class);
        $response = $controller->index();
        $this->assertEquals("Hello from ExampleService!", $response);
    }

    public function testCallMethod()
    {
        $controller = $this->container->make(ExampleAction::class);
        $response = $this->container->callMethod($controller, 'testMethod');
        $this->assertEquals("Hello from ExampleService!", $response);
    }


    public function testSingletonBehavior()
    {
        $service1 = $this->container->make(ExampleService::class);
        $service2 = $this->container->make(ExampleService::class);
        $this->assertSame($service1, $service2);
    }


    public function testMakeWithInvalidType()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid type provided for make method.");
        $this->container->make(12345); // Passando um tipo inválido
    }

    public function testMakeClassNotInstantiable()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Class MiniRestFramework\Tests\Examples\Objects\NonInstantiableClass cannot be instantiated.");
        $this->container->make(NonInstantiableClass::class);
    }

    public function testMakeObject()
    {
        $instance = $this->container->make(Request::class);
        $this->assertInstanceOf(Request::class, $instance);
    }

//    public function testBindingInterfaceToConcreteImplementation()
//    {
//        // Cria uma nova instância do container
//        $container = new Container();
//
//        // Faz o binding da interface 'ServiceInterface' para a implementação 'ServiceConcrete'
//        $container->bind(ServiceInterface::class, ServiceConcrete::class);
//
//        // Resolve a interface do container
//        $resolvedInstance = $container->make(ServiceInterface::class);
//
//        // Verifica se a instância resolvida é do tipo 'ServiceConcrete'
//        $this->assertInstanceOf(ServiceConcrete::class, $resolvedInstance);
//
//        // Verifica se o método 'execute' retorna o valor correto
//        $this->assertEquals('ServiceConcrete executed', $resolvedInstance->execute());
//    }


}
