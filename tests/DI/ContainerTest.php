<?php

namespace MiniRestFramework\Tests\DI;

use MiniRestFramework\DI\Container;
use MiniRestFramework\Http\Request\Request;
use MiniRestFramework\Tests\Examples\Contracts\PaymentGatewayInterface;
use MiniRestFramework\Tests\Examples\Contracts\ServiceInterface;
use MiniRestFramework\Tests\Examples\Objects\ExampleAction;
use MiniRestFramework\Tests\Examples\Objects\ExampleRepository;
use MiniRestFramework\Tests\Examples\Objects\ExampleService;
use MiniRestFramework\Tests\Examples\Objects\MainService;
use MiniRestFramework\Tests\Examples\Objects\NonInstantiableClass;
use MiniRestFramework\Tests\Examples\Objects\PayPalGateway;
use MiniRestFramework\Tests\Examples\Objects\ServiceConcrete;
use MiniRestFramework\Tests\Examples\Objects\SingletonTestService;
use MiniRestFramework\Tests\Examples\Objects\StripeGateway;
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

        $this->container->singleton(ExampleService::class, ExampleService::class);

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

    public function testBindingInterfaceToConcreteImplementation()
    {
        // Faz o binding da interface 'ServiceInterface' para a implementação 'ServiceConcrete'
        $this->container->bind(ServiceInterface::class, ServiceConcrete::class);

        // Resolve a interface do container
        $resolvedInstance = $this->container->make(ServiceInterface::class);

        // Verifica se a instância resolvida é do tipo 'ServiceConcrete'
        $this->assertInstanceOf(ServiceConcrete::class, $resolvedInstance);

        // Verifica se o método 'execute' retorna o valor correto
        $this->assertEquals('ServiceConcrete executed', $resolvedInstance->execute());
    }

    public function testSingletonResolution()
    {
        // Registra um singleton no container
        $this->container->singleton(SingletonTestService::class, SingletonTestService::class);

        // Resolve a mesma instância duas vezes
        $instanceOne = $this->container->make(SingletonTestService::class);
        $instanceTwo = $this->container->make(SingletonTestService::class);

        // Verifica se ambas as instâncias são a mesma (singleton)
        $this->assertSame($instanceOne, $instanceTwo);

        // Verifica se os números aleatórios das instâncias são iguais
        $this->assertEquals($instanceOne->randomNumber, $instanceTwo->randomNumber);
    }

    public function testConstructorDependencyResolution()
    {
        // Resolve a classe principal que depende de outra classe
        $resolvedInstance = $this->container->make(MainService::class);

        // Verifica se a instância resolvida é do tipo MainService
        $this->assertInstanceOf(MainService::class, $resolvedInstance);

        // Verifica se a dependência foi injetada e o método funciona corretamente
        $this->assertEquals('Dependent service message', $resolvedInstance->getDependentMessage());
    }

    public function testBindingOverride()
    {
        // Bind inicial
        $this->container->bind(PaymentGatewayInterface::class, PayPalGateway::class);
        $resolvedPayPal = $this->container->make(PaymentGatewayInterface::class);
        $this->assertEquals('Processed by PayPal', $resolvedPayPal->processPayment());

        // Sobrescreve o binding
        $this->container->bind(PaymentGatewayInterface::class, StripeGateway::class);
        $resolvedStripe = $this->container->make(PaymentGatewayInterface::class);
        $this->assertEquals('Processed by Stripe', $resolvedStripe->processPayment());
    }
}
