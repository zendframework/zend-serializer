<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Serializer\Adapter;

use Zend\Json\Decoder;
use Zend\Json\Encoder;
use Zend\Stdlib\ErrorHandler;
use Zend\Serializer\Exception;

class PhpCode extends AbstractAdapter
{
    /**
     * Encoder/Serialize PHP using Zend\Json\Encoder or serialize
     *
     * @param  mixed $value
     * @return string
     * @throws Exception\RuntimeException only if the parameter is already serialized
     */
    public function serialize($value)
    {
        if ($this->isSerialized($value)) {
            throw new Exception\RuntimeException('Value is already serialized');
        }

        if (!is_object($value)) {
            return serialize($value);
        }

        return Encoder::encode($value);
    }

    /**
     * Deserialize PHP string
     *
     * @param string $code
     * @return mixed (can be string or object)
     */
    public function unserialize($code)
    {
        if (!$this->validateString($code)) {
            return unserialize($code);
        }

        $decoded = @Decoder::decode($code);

        if (!is_object($decoded) && $this->isSerialized($decoded)) {
            return unserialize($decoded);
        }

        if (is_object($decoded)) {
            $code = $this->extractClass($decoded);
        }

        return $code;
    }

    /**
     * Validation to check if we can unserialize and/or decode
     *
     * @param $code
     * @return bool
     */
    private function validateString($code)
    {
        if (!$this->isSerialized($code) && @unserialize($code) === $code) {
            return false;
        }

        try {
            Decoder::decode($code);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @param \StdClass $object
     *
     * @return mixed
     * @throws Exception\RuntimeException if no class name is found, then we cannot re-generate the class
     */
    private function extractClass(\StdClass $object)
    {
        if ($object->__className === null || $object->__className === false) {
            throw new Exception\RuntimeException('Cannot retrieve class name');
        }

        // Get original class name
        $className = $object->__className;

        // Retrieve current class name
        $serializedObjClassName = strstr(serialize($object), '"');
        $stdClassName = strstr($serializedObjClassName, ':');

        // Replace class name with the original class name
        $serializedObject = sprintf('O:%d:"%s"%s', strlen($className), $className, $stdClassName);

        // Unserialize back into object
        return unserialize($serializedObject);
    }

    /**
     * Check if string is already serialized
     *
     * @param mixed $code
     * @return bool
     */
    private function isSerialized($code)
    {
        ErrorHandler::start(E_ALL);
        $unserialize = unserialize($code);
        $errors = ErrorHandler::stop();

        if ($errors === false || $unserialize === 'b:0;') {
            return true;
        }

        return false;
    }
}
