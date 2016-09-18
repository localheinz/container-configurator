<?php

namespace tests\unit\TomPHP\ContainerConfigurator;

use PHPUnit_Framework_TestCase;
use TomPHP\ContainerConfigurator\ServiceDefinition;

final class ServiceDefinitionTest extends PHPUnit_Framework_TestCase
{
    public function testItCreatesFromConfig()
    {
        $config = [
            'class'     => __CLASS__,
            'singleton' => false,
            'arguments' => ['argument1', 'argument2'],
            'methods'   => ['setSomething' => ['value']],
        ];

        $definition = new ServiceDefinition('service_name', $config);

        assertEquals('service_name', $definition->getName());
        assertEquals(__CLASS__, $definition->getClass());
        assertFalse($definition->isSingleton());
        assertEquals(['argument1', 'argument2'], $definition->getArguments());
        assertEquals(['setSomething' => ['value']], $definition->getMethods());
    }

    public function testClassDefaultsToKey()
    {
        $definition = new ServiceDefinition('service_name', []);

        assertEquals('service_name', $definition->getClass());
    }

    public function testSingletonDefaultsToFalse()
    {
        $definition = new ServiceDefinition('service_name', []);

        assertFalse($definition->isSingleton());
    }

    public function testSingletonDefaultCanBeSetToToTrue()
    {
        $definition = new ServiceDefinition('service_name', [], true);

        assertTrue($definition->isSingleton());
    }

    public function testArgumentsDefaultToAnEmptyList()
    {
        $definition = new ServiceDefinition('service_name', []);

        assertEquals([], $definition->getArguments());
    }

    public function testMethodsDefaultToAnEmptyList()
    {
        $definition = new ServiceDefinition('service_name', []);

        assertEquals([], $definition->getMethods());
    }
}
