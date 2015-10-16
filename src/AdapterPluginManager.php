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
        Adapter\IgBinary::class     => InvokableFactory::class,
        Adapter\Json::class         => InvokableFactory::class,
        Adapter\MsgPack::class      => InvokableFactory::class,
        Adapter\PhpCode::class      => InvokableFactory::class,
        Adapter\PhpSerialize::class => InvokableFactory::class,
        Adapter\PythonPickle::class => InvokableFactory::class,
        Adapter\Wddx::class         => InvokableFactory::class
    ];

    /**
     * Validate the plugin
     *
     * Checks that the adapter loaded is an instance
     * of Adapter\AdapterInterface.
     *
     * @param  mixed $plugin
     * @return void
     * @throws Exception\RuntimeException if invalid
     */
    public function validate($plugin)
    {
        if ($plugin instanceof Adapter\AdapterInterface) {
            // we're okay
            return;
        }

        throw new Exception\RuntimeException(sprintf(
            'Plugin of type %s is invalid; must implement %s\Adapter\AdapterInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }
}
