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

/**
 * Interface for the command bus.
 *
 * A command bus handles a command by matching the command to its handler. The matching handler receives the given
 * command for processing.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
interface CommandBusInterface
{
    /**
     *
     *
     * @param CommandInterface $command
     */
    public function handle(CommandInterface $command);
}
