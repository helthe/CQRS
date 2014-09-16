# Helthe CQRS [![Build Status](https://travis-ci.org/helthe/CQRS.png?branch=master)](https://travis-ci.org/helthe/CQRS) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/helthe/CQRS/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/helthe/CQRS/?branch=master)

Helthe CQRS is a small library implementing [command-query separation](http://en.wikipedia.org/wiki/Command%E2%80%93query_separation). It's
based on the refactored version of [LiteCQRS](https://github.com/beberlei/litecqrs-php) and the work of [Mark Nijhof](https://github.com/MarkNijhof/Fohjin)
for his [CQRS book](https://leanpub.com/cqrs).

Currently, the library only implements command handling using a command bus for communication.

## Installation

### Using Composer

#### Manually

Add the following in your `composer.json`:

```json
{
    "require": {
        // ...
        "helthe/cqrs": "dev-master"
    }
}
```

#### Using the command line

```bash
$ composer require 'helthe/cqrs=dev-master'
```

## Usage

The component contains mainly helper interfaces for implementing CQRS. Some basic implementations are also included.

```php
use Helthe\Component\CQRS\Bus\SequentialCommandBus;
use Helthe\Component\CQRS\Command\CommandInterface;
use Helthe\Component\CQRS\CommandHandler\CommandHandlerInterface;
use Helthe\Component\CQRS\CommandHandler\MemoryCommandHandlerLocator;

/* @var CommandInterface */
$command = new Command()
/* @var CommandHandlerInterface */
$handler = new CommandHandler()

$locator = new MemoryCommandHandlerLocator();
$locator->register(get_class($command), $handler);

$bus = new SequentialCommandBus($locator);

$bus->dispatch($command);
```

## Bugs

For bugs or feature requests, please [create an issue](https://github.com/helthe/CQRS/issues/new).