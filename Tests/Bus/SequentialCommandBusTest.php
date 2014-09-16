<?php

/*
 * This file is part of the Helthe CQRS package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Component\CQRS\Tests\Bus;

use Helthe\Component\CQRS\Bus\SequentialCommandBus;

class SequentialCommandBusTest extends \PHPUnit_Framework_TestCase
{
    public function testHandleASupportedCommand()
    {
        $command = $this->getCommandMock();

        $handler = $this->getCommandHandlerMock();
        $handler->expects($this->once())
                ->method('supports')
                ->with($this->equalTo($command))
                ->will($this->returnValue(true));
        $handler->expects($this->once())
                ->method('execute')
                ->with($this->equalTo($command));

        $locator = $this->getCommandHandlerLocatorMock();
        $locator->expects($this->once())
                ->method('locate')
                ->with($this->equalTo($command))
                ->will($this->returnValue($handler));

        $bus = new SequentialCommandBus($locator);

        $bus->dispatch($command);
    }

    public function testHandleAppendsCommandWhileExecuting()
    {
        $command1 = $this->getCommandMock();
        $command2 = $this->getCommandMock();

        $handler = $this->getCommandHandlerMock();
        $handler->expects($this->never())
                ->method('supports');
        $handler->expects($this->never())
                ->method('execute');

        $locator = $this->getCommandHandlerLocatorMock();
        $locator->expects($this->never())
                ->method('locate');

        $bus = new SequentialCommandBus($locator);

        $reflection = new \ReflectionClass('Helthe\Component\CQRS\Bus\SequentialCommandBus');
        $executingProperty = $reflection->getProperty('executing');
        $executingProperty->setAccessible(true);
        $executingProperty->setValue($bus, true);

        $commandsProperty = $reflection->getProperty('commands');
        $commandsProperty->setAccessible(true);
        $commandsProperty->setValue($bus, array($command1));

        $bus->dispatch($command2);
        $this->assertSame(array($command1, $command2), $commandsProperty->getValue($bus));
    }

    public function testHandleACommandSequence()
    {
        $command1 = $this->getCommandMock();
        $command2 = $this->getCommandMock();

        $handler = $this->getCommandHandlerMock();
        $handler->expects($this->at(0))
                ->method('supports')
                ->with($this->identicalTo($command1))
                ->will($this->returnValue(true));
        $handler->expects($this->at(1))
                ->method('execute')
                ->with($this->identicalTo($command1));
        $handler->expects($this->at(2))
                ->method('supports')
                ->with($this->identicalTo($command2))
                ->will($this->returnValue(true));
        $handler->expects($this->at(3))
                ->method('execute')
                ->with($this->identicalTo($command2));

        $locator = $this->getCommandHandlerLocatorMock();
        $locator->expects($this->at(0))
                ->method('locate')
                ->with($this->identicalTo($command1))
                ->will($this->returnValue($handler));
        $locator->expects($this->at(1))
                ->method('locate')
                ->with($this->identicalTo($command2))
                ->will($this->returnValue($handler));

        $bus = new SequentialCommandBus($locator);

        $reflection = new \ReflectionClass('Helthe\Component\CQRS\Bus\SequentialCommandBus');
        $commandsProperty = $reflection->getProperty('commands');
        $commandsProperty->setAccessible(true);
        $commandsProperty->setValue($bus, array($command1));

        $bus->dispatch($command2);
    }

    /**
     * @expectedException Helthe\Component\CQRS\Exception\InvalidCommandException
     */
    public function testHandleAnUnsupportedCommand()
    {
        $command = $this->getCommandMock();

        $handler = $this->getCommandHandlerMock();
        $handler->expects($this->once())
                ->method('supports')
                ->with($this->equalTo($command))
                ->will($this->returnValue(false));
        $handler->expects($this->never())
                ->method('execute');

        $locator = $this->getCommandHandlerLocatorMock();
        $locator->expects($this->once())
                ->method('locate')
                ->with($this->equalTo($command))
                ->will($this->returnValue($handler));

        $bus = new SequentialCommandBus($locator);

        $bus->dispatch($command);
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

    /**
     * Get a mock of a command handler locator.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getCommandHandlerLocatorMock()
    {
        return $this->getMock('Helthe\Component\CQRS\CommandHandler\CommandHandlerLocatorInterface');
    }
}
