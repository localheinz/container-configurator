<?php

namespace tests\unit\TomPHP\ContainerConfigurator\Exception;

use LogicException;
use PHPUnit_Framework_TestCase;
use TomPHP\ContainerConfigurator\Exception\Exception;
use TomPHP\ContainerConfigurator\Exception\UnknownContainerException;

final class UnknownContainerExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testItImplementsTheBaseExceptionType()
    {
        $this->assertInstanceOf(Exception::class, new UnknownContainerException());
    }

    public function testItIsADomainException()
    {
        $this->assertInstanceOf(LogicException::class, new UnknownContainerException());
    }

    public function testItCanBeCreatedFromFileExtension()
    {
        $exception = UnknownContainerException::fromContainerName('example-container', ['container-a', 'container-b']);

        $this->assertSame(
            'Container example-container is unknown; known containers are ["container-a", "container-b"].',
            $exception->getMessage()
        );
    }
}
