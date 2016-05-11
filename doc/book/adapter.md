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

Option  | Data Type | Default Value | Description
--------|-----------|---------------|------------
comment | `string`  |               | An optional comment that appears in the packet header.

## The Json Adapter

The [JSON](http://wikipedia.org/wiki/JavaScript_Object_Notation) adapter provides a bridge to the
`Zend\Json` component. Please read the [ZendJson documentation](zend.json.introduction) for
further information.

Available options include:

Option                  | Data Type                | Default Value
------------------------|--------------------------|--------------
cycle_check             | `boolean`                | `false`
object_decode_type      | `Zend\Json\Json::TYPE_*` | `Zend\Json\Json::TYPE_ARRAY`
enable_json_expr_finder | `boolean`                | `false`

## The PythonPickle Adapter

This adapter converts [PHP](http://php.net) types to a [Python
Pickle](http://docs.python.org/library/pickle.html) string representation. With it, you can read the
serialized data with Python and read Pickled data of Python with [PHP](http://php.net).

Available options include:

Option   | Data Type           | Default Value | Description
---------|---------------------|---------------|------------
protocol | `integer` (0/1/2/3) | 0             | The Pickle protocol version used on serialize

### Datatype merging (PHP to Python Pickle)

[PHP Type](http://php.net/) | [Python Pickle Type](http://docs.python.org/library/pickle.html)
----------------------------|-----------------------------------------------------------------
`NULL`                      | None
`boolean`                   | `boolean`
`integer`                   | `integer`
`float`                     | `float`
`string`                    | `string`
`array` list                | `list`
`array` map                 | `dictionary`
`object`                    | `dictionary`

### Datatype merging (Python Pickle to PHP)

[Python Pickle Type](http://docs.python.org/library/pickle.html) | [PHP Type](http://php.net/)
-----------------------------------------------------------------|----------------------------
`None`                                                           | `NULL`
`boolean`                                                        | `boolean`
`integer`                                                        | `integer`
`long`                                                           | `integer` or `float` or `string` or `Zend\Serializer\Exception\ExceptionInterface`
`float`                                                          | `float`
`string`                                                         | `string`
`bytes`                                                          | `string`
`unicode string`                                                 | `string` UTF-8
`list`                                                           | `array` list
`tuple`                                                          | `array` list
`dictionary`                                                     | `array` map
All other types                                                  | `Zend\Serializer\Exception\ExceptionInterface`

## The PhpCode Adapter

The `Zend\Serializer\Adapter\PhpCode` adapter generates a parsable [PHP](http://php.net) code
representation using [var\_export()](http://php.net/manual/function.var-export.php). On restoring,
the data will be executed using [eval](http://php.net/manual/function.eval.php).

There are no configuration options for this adapter.

> ### Warning
#### Unserializing objects
Objects will be serialized using the
[\_\_set\_state](http://php.net/manual/language.oop5.magic.php#language.oop5.magic.set-state) magic
method. If the class doesn't implement this method, a fatal error will occur during execution.

> ### Warning
#### Uses eval()
The `PhpCode` adapter utilizes `eval()` to unserialize. This introduces both a performance and
potential security issue as a new process will be executed. Typically, you should use the
`PhpSerialize` adapter unless you require human-readability of the serialized data.