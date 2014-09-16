<?php

/*
 * This file is part of the Helthe CQRS package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Component\CQRS\CommandHandler;

use Helthe\Component\CQRS\Command\CommandInterface;
use Helthe\Component\CQRS\Exception\CommandHandlerNotFoundException;

/**
 * Generic command handler locator that stores command handlers internally.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class MemoryCommandHandlerLocator implements CommandHandlerLocatorInterface
{
    /**
     * Command handlers.
     *
     * @var CommandHandlerInterface[]
     */
    private $handlers = array();

    /**
     * {@inheritdoc}
     */
    public function locate(CommandInterface $command)
    {
        $name = get_class($command);

        if (!isset($this->handlers[$name])) {
            throw new CommandHandlerNotFoundException(sprintf('No command handler registered for "%s"', get_class($command)));
        }

        return $this->handlers[$name];
    }

    /**
     * Registers a command handler for the given command name.
     *
     * The command name should be the full class name of the command.
     *
     * @param string                  $name
     * @param CommandHandlerInterface $handler
     */
    public function register($name, CommandHandlerInterface $handler)
    {
        $this->handlers[$name] = $handler;
    }
}
