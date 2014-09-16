<?php

/*
 * This file is part of the Helthe CQRS package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Component\CQRS\Tests\CommandHandler;

use Helthe\Component\CQRS\CommandHandler\MemoryCommandHandlerLocator;

class MemoryCommandHandlerLocatorTest extends \PHPUnit_Framework_TestCase
{
    public function testLocate()
    {
        $command = $this->getCommandMock();
        $handler = $this->getCommandHandlerMock();
        $locator = new MemoryCommandHandlerLocator();

        $locator->register(get_class($command), $handler);

        $this->assertSame($handler, $locator->locate($command));
    }

    /**
     * @expectedException Helthe\Component\CQRS\Exception\CommandHandlerNotFoundException
     */
    public function testLocateNonexistentCommandHandler()
    {
        $command = $this->getCommandMock();
        $locator = new MemoryCommandHandlerLocator();

        $locator->locate($command);
    }

    public function testRegister()
    {
        $handler = $this->getCommandHandlerMock();
        $locator = new MemoryCommandHandlerLocator();

        $locator->register('foo', $handler);

        $reflection = new \ReflectionClass('Helthe\Component\CQRS\CommandHandler\MemoryCommandHandlerLocator');
        $handlersProperty = $reflection->getProperty('handlers');
        $handlersProperty->setAccessible(true);

        $this->assertSame(array('foo' => $handler), $handlersProperty->getValue($locator));
    }

    /**
     * Get a mock of a command.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getCommandMock()
    {
        return $this->getMock('Helthe\Component\CQRS\Command\CommandInterface');
    }

    /**
     * Get a mock of a command handler.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getCommandHandlerMock()
    {
        return $this->getMock('Helthe\Component\CQRS\CommandHandler\CommandHandlerInterface');
    }
}
