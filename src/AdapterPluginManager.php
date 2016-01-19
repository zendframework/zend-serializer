<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Serializer;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\ServiceManager\Exception\InvalidServiceException;

/**
 * Plugin manager implementation for serializer adapters.
 *
 * Enforces that adapters retrieved are instances of
 * Adapter\AdapterInterface. Additionally, it registers a number of default
 * adapters available.
 */
class AdapterPluginManager extends AbstractPluginManager
{
    protected $aliases = [
        'igbinary'     => Adapter\IgBinary::class,
        'IgBinary'     => Adapter\IgBinary::class,
        'json'         => Adapter\Json::class,
        'Json'         => Adapter\Json::class,
        'msgpack'      => Adapter\MsgPack::class,
        'MsgPack'      => Adapter\MsgPack::class,
        'phpcode'      => Adapter\PhpCode::class,
        'PhpCode'      => Adapter\PhpCode::class,
        'phpserialize' => Adapter\PhpSerialize::class,
        'PhpSerialize' => Adapter\PhpSerialize::class,
        'pythonpickle' => Adapter\PythonPickle::class,
        'PythonPickle' => Adapter\PythonPickle::class,
        'wddx'         => Adapter\Wddx::class,
        'Wddx'         => Adapter\Wddx::class
    ];

    protected $factories = [
        Adapter\IgBinary::class             => InvokableFactory::class,
        'zendserializeradapterigbinary'     => InvokableFactory::class,
        Adapter\Json::class                 => InvokableFactory::class,
        'zendserializeradapterjson'         => InvokableFactory::class,
        Adapter\MsgPack::class              => InvokableFactory::class,
        'zendserializeradaptermsgpack'      => InvokableFactory::class,
        Adapter\PhpCode::class              => InvokableFactory::class,
        'zendserializeradapter\phpcode'     => InvokableFactory::class,
        Adapter\PhpSerialize::class         => InvokableFactory::class,
        'zendserializeradapterphpserialize' => InvokableFactory::class,
        Adapter\PythonPickle::class         => InvokableFactory::class,
        'zendserializeradapterpythonpickle' => InvokableFactory::class,
        Adapter\Wddx::class                 => InvokableFactory::class,
        'zendserializeradapterwddx'         => InvokableFactory::class
    ];

    protected $instanceOf = Adapter\AdapterInterface::class;

    /**
     * Validate the plugin is of the expected type (v3).
     *
     * Validates against `$instanceOf`.
     *
     * @param mixed $instance
     * @throws InvalidServiceException
     */
    public function validate($instance)
    {
        if (! $instance instanceof $this->instanceOf) {
            throw new InvalidServiceException(sprintf(
                '%s can only create instances of %s; %s is invalid',
                get_class($this),
                $this->instanceOf,
                (is_object($instance) ? get_class($instance) : gettype($instance))
            ));
        }
    }

    /**
     * Validate the plugin is of the expected type (v2).
     *
     * Proxies to `validate()`.
     *
     * @param mixed $instance
     * @throws InvalidServiceException
     */
    public function validatePlugin($instance)
    {
        $this->validate($instance);
    }
}
