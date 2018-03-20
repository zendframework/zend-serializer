<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Serializer\Adapter;

use Zend\Json\Json as ZendJson;
use Zend\Serializer\Exception;

class PhpSerializeOptions extends AdapterOptions
{
    /**
     * The list of allowed classes for unserialization (PHP 7.0+)
     * Possible values:
     * Array of class names that are allowed to be unserialized
     * or true if all classes should be allowed (behavior of pre PHP 7.0)
     * or false if no classes should be allowed
     *
     * @var array|bool
     */
    protected $unserializeClassWhitelist = true;

    /**
     * @param  array|bool $unserializeClassWhitelist
     *
     * @return PhpSerializeOptions
     */
    public function setUnserializeClassWhitelist($unserializeClassWhitelist)
    {
        if (($unserializeClassWhitelist !== true) && (PHP_MAJOR_VERSION < 7)) {
            throw new Exception\InvalidArgumentException(
                'Class whitelist for unserialize() is only available on PHP 7.0 or higher.'
            );
        }

        $this->unserializeClassWhitelist = $unserializeClassWhitelist;
        return $this;
    }

    /**
     * @return array|bool
     */
    public function getUnserializeClassWhitelist()
    {
        return $this->unserializeClassWhitelist;
    }
}
