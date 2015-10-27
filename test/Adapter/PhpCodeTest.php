<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace ZendTest\Serializer\Adapter;

use Zend\Serializer;

/**
 * @covers Zend\Serializer\Adapter\PhpCode
 */
class PhpCodeTest extends \PHPUnit_Framework_TestCase
{
    /** @var Serializer\Adapter\PhpCode */
    private $adapter;

    public function setUp()
    {
        $this->adapter = new Serializer\Adapter\PhpCode();
    }

    /**
     * @dataProvider serializedValuesProvider
     */
    public function testSerialize($unserialized, $serialized)
    {
        $this->assertEquals($serialized, $this->adapter->serialize($unserialized));
    }

    /**
     * @dataProvider serializedValuesProvider
     */
    public function testUnserialize($unserialized, $serialized)
    {
        $this->assertEquals($unserialized, $this->adapter->unserialize($serialized));
    }

    public function serializedValuesProvider()
    {
        return [
            // Description => [unserialized, serialized]
            'String' => ['test', serialize('test')],
            'true' => [true, serialize(true)],
            'false' => [false, serialize(false)],
            'null' => [null, serialize(null)],
            'int' => [1, serialize(1)],
            'float' => [1.2, serialize(1.2)],

            // Boolean as string
            '"true"' => ['true', serialize('true')],
            '"false"' => ['false', serialize('false')],
            '"null"' => ['null', serialize('null')],
            '"1"' => ['1', serialize('1')],
            '"1.2"' => ['1.2', serialize('1.2')],

            'PHP Code with tags' => ['<?php echo "test"; ?>', serialize('<?php echo "test"; ?>')]
        ];
    }
}
