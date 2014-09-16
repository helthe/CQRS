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
 * Exception thrown when a given command is invalid.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class InvalidCommandException extends \InvalidArgumentException implements ExceptionInterface
{
}
