# Zend\\Serializer\\Adapter

`Zend\Serializer` adapters create a bridge for different methods of serializing with very little
effort.

Every adapter has different pros and cons. In some cases, not every [PHP](http://php.net) datatype
(e.g., objects) can be converted to a string representation. In most such cases, the type will be
converted to a similar type that is serializable.

As an example, [PHP](http://php.net) objects will often be cast to arrays. If this fails, a
`Zend\Serializer\Exception\ExceptionInterface` will be thrown.

## The PhpSerialize Adapter

The `Zend\Serializer\Adapter\PhpSerialize` adapter uses the built-in `un/serialize`
[PHP](http://php.net) functions, and is a good default adapter choice.

There are no configurable options for this adapter.

## The IgBinary Adapter

[Igbinary](http://pecl.php.net/package/igbinary) is Open Source Software released by Sulake Dynamoid
Oy and since 2011-03-14 moved to [PECL](http://pecl.php.net) maintained by Pierre Joye. It's a
drop-in replacement for the standard [PHP](http://php.net) serializer. Instead of time and space
consuming textual representation, igbinary stores [PHP](http://php.net) data structures in a compact
binary form. Savings are significant when using memcached or similar memory based storages for
serialized data.

You need the igbinary [PHP](http://php.net) extension installed on your system in order to use this
adapter.

There are no configurable options for this adapter.

## The Wddx Adapter

[WDDX](http://wikipedia.org/wiki/WDDX) (Web Distributed Data eXchange) is a programming-language-,
platform-, and transport-neutral data interchange mechanism for passing data between different
environments and different computers.

The adapter simply uses the
[[wddx](http://wikipedia.org/wiki/WDDX)\*()](http://php.net/manual/book.wddx.php)
[PHP](http://php.net) functions. Please read the [PHP](http://php.net) manual to determine how you
may enable them in your [PHP](http://php.net) installation.

Additionally, the [SimpleXML](http://php.net/manual/book.simplexml.php) [PHP](http://php.net)
extension is used to check if a returned `NULL` value from `wddx_unserialize()` is based on a
serialized `NULL` or on invalid data.

Available options include:

## The Json Adapter

The [JSON](http://wikipedia.org/wiki/JavaScript_Object_Notation) adapter provides a bridge to the
`Zend\Json` component. Please read the \[ZendJson documentation\](zend.json.introduction) for
further information.

Available options include:

## The PythonPickle Adapter

This adapter converts [PHP](http://php.net) types to a [Python
Pickle](http://docs.python.org/library/pickle.html) string representation. With it, you can read the
serialized data with Python and read Pickled data of Python with [PHP](http://php.net).

Available options include:

## The PhpCode Adapter

The `Zend\Serializer\Adapter\PhpCode` adapter generates a parsable [PHP](http://php.net) code
representation using [var\_export()](http://php.net/manual/function.var-export.php). On restoring,
the data will be executed using [eval](http://php.net/manual/function.eval.php).

There are no configuration options for this adapter.

> ## Warning
#### Unserializing objects
Objects will be serialized using the
[\_\_set\_state](http://php.net/manual/language.oop5.magic.php#language.oop5.magic.set-state) magic
method. If the class doesn't implement this method, a fatal error will occur during execution.

> ## Warning
#### Uses eval()
The `PhpCode` adapter utilizes `eval()` to unserialize. This introduces both a performance and
potential security issue as a new process will be executed. Typically, you should use the
`PhpSerialize` adapter unless you require human-readability of the serialized data.
