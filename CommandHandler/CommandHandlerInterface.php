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
use Helthe\Component\CQRS\Exception\InvalidCommandException;

/**
 * Interface for command handlers.
 *
 * A command handler executes the given command if it supports it.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
interface CommandHandlerInterface
{
    /**
     * Executes the given command.
     *
     * @param CommandInterface $command
     *
     * @throws InvalidCommandException
     */
    public function execute(CommandInterface $command);

    /**
     * Checks if the command handler supports the given command.
     *
     * @param CommandInterface $command
     *
     * @return bool
     */
    public function supports(CommandInterface $command);
}
