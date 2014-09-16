<?php

/*
 * This file is part of the Helthe CQRS package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Component\CQRS\Exception;

/**
 * Exception thrown when a command handler cannot be found.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class CommandHandlerNotFoundException extends \RuntimeException implements ExceptionInterface
{
}
