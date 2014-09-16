<?php

/*
 * This file is part of the Helthe CQRS package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Component\CQRS\Bus;

use Helthe\Component\CQRS\Command\CommandInterface;
use Helthe\Component\CQRS\CommandHandler\CommandHandlerLocatorInterface;
use Helthe\Component\CQRS\Exception\InvalidCommandException;

/**
 * Command bus that handles commands sequentially.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class SequentialCommandBus implements CommandBusInterface
{
    /**
     * Queue of commands to be handled by the bus.
     *
     * @var CommandInterface[]
     */
    private $commands = array();

    /**
     * Flag that determines if the command bus is currently executing a command.
     *
     * @var bool
     */
    private $executing = false;

    /**
     * Command handler locator used by the command bus.
     *
     * @var CommandHandlerLocatorInterface
     */
    private $locator;

    /**
     * Constructor.
     *
     * @param CommandHandlerLocatorInterface $locator
     */
    public function __construct(CommandHandlerLocatorInterface $locator)
    {
        $this->locator = $locator;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(CommandInterface $command)
    {
        $this->commands[] = $command;

        if ($this->executing) {
            return;
        }

        while ($command = array_shift($this->commands)) {
            $this->execute($command);
        }
    }

    /**
     * Executes a command.
     *
     * @param CommandInterface $command
     *
     * @throws InvalidCommandException
     */
    private function execute(CommandInterface $command)
    {
        $handler = $this->locator->locate($command);

        if (!$handler->supports($command)) {
            throw new InvalidCommandException(sprintf('The registered command handler doesn\'t support "%s"', get_class($command)));
        }

        $this->executing = true;

        $handler->execute($command);

        $this->executing = false;
    }
}
