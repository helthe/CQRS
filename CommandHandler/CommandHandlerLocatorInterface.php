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
 * Interface for command handler locators.
 *
 * A locator locates the command handler based on the given command. A command should map to a single command handler.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
interface CommandHandlerLocatorInterface
{
    /**
     * Locates the command handler for the given command.
     *
     * @param CommandInterface $command
     *
     * @return CommandHandlerInterface
     *
     * @throws CommandHandlerNotFoundException
     */
    public function locate(CommandInterface $command);
}
