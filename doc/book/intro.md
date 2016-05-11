# Introduction to Zend\Serializer

The `Zend\Serializer` component provides an adapter based interface to simply
generate storable representation of PHP types by different facilities, and
recover.

For more information what a serializer is read the wikipedia page of
[Serialization](http://en.wikipedia.org/wiki/Serialization).

## Quick Start

Serializing adapters can either be created from the provided
`Zend\Serializer\Serializer::factory` method, or by simply instantiating one of
the `Zend\Serializer\Adapter\*` classes.

```php
use Zend\Serializer\Serializer;

// Via factory:
$serializer = Zend\Serializer\Serializer::factory('PhpSerialize');

// Alternately:
$serializer = new Zend\Serializer\Adapter\PhpSerialize();

// Now $serializer is an instance of Zend\Serializer\Adapter\AdapterInterface,
// specifically Zend\Serializer\Adapter\PhpSerialize

try {
    $serialized = $serializer->serialize($data);
    // now $serialized is a string

    $unserialized = $serializer->unserialize($serialized);
    // now $data == $unserialized
} catch (Zend\Serializer\Exception\ExceptionInterface $e) {
    echo $e;
}
```

The method `serialize()` generates a storable string. To regenerate this
serialized data you can simply call the method `unserialize()`.

Any time an error is encountered serializing or unserializing,
`Zend\Serializer` will throw a `Zend\Serializer\Exception\ExceptionInterface`.

Because of an application often uses internally only one serializer it is
possible to define and use a default serializer. That serializer will be used by
default by other components like `Zend\Cache\Storage\Plugin\Serializer`.

To use the default serializer you can simply use the static serialization
methods of the basic `Zend\Serializer\Serializer`:

```php
use Zend\Serializer\Serializer;

try {
    $serialized = Serializer::serialize($data);
    // now $serialized is a string

    $unserialized = Serializer::unserialize($serialized);
    // now $data == $unserialized
} catch (Zend\Serializer\Exception\ExceptionInterface $e) {
    echo $e;
}
```

## Basic configuration Options

To configure a serializer adapter, you can optionally use an instance of
`Zend\Serializer\Adapter\AdapterOptions`, an instance of one of the adapter
specific options class, an `array` or an instance of `Traversable`. The adapter
will convert it into the adapter specific options class instance (if present) or
into the basic `Zend\Serializer\Adapter\AdapterOptions` class instance.

Options can be passed as second argument to the provided
`Zend\Serializer\Serializer::factory` method, using the method `setOptions` or
set as constructor argument.

## Available Methods

Each serializer implements the interface
`Zend\Serializer\Adapter\AdapterInterface`.

This interface defines the following methods:

Method signature | Description
---------------- | -----------
`serialize(mixed $value) : string` | Generates a storable representation of a value.
`unserialize(string $value) : mixed` | Creates a PHP value from a stored representation.

The basic class `Zend\Serializer\Serializer` will be used to instantiate the
adapters, to configure the factory and to handle static serializing.

It defines the following static methods:

Method signature | Description
---------------- | -----------
`factory(string|Zend\Serializer\Adapter\AdapterInterface $adapterName, Zend\Serializer\Adapter\AdapterOptions|array|Traversable|null $adapterOptions = null) : Zend\Serializer\Adapter\AdapterInterface` | Create a serializer adapter instance.
`setAdapterPluginManager(Zend\Serializer\AdapterPluginManager $adapters) : void` | Change the adapter plugin manager.
`getAdapterPluginManager() : Zend\Serializer\AdapterPluginManager` | Get the adapter plugin manager.
`resetAdapterPluginManager() : void` | Resets the internal adapter plugin manager.
`setDefaultAdapter(string|Zend\Serializer\Adapter\AdapterInterface $adapter, Zend\Serializer\Adapter\AdapterOptions|array|Traversable|null $adapterOptions = null) : void` | Change the default adapter.
`getDefaultAdapter() : Zend\Serializer\Adapter\AdapterInterface` | Get the default adapter.
`serialize(mixed $value, string|Zend\Serializer\Adapter\AdapterInterface|null $adapter = null, Zend\Serializer\Adapter\AdapterOptions|array|Traversable|null $adapterOptions = null) : string` | Generates a storable representation of a value using the default adapter. Optionally different adapter could be provided as second argument.
`unserialize(string $value, string|Zend\Serializer\Adapter\AdapterInterface|null $adapter = null, Zend\Serializer\Adapter\AdapterOptions|array|Traversable|null $adapterOptions = null) : mixed` | Creates a PHP value from a stored representation using the default adapter. Optionally different adapter could be provided as second argument.