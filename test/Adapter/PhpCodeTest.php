<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Serializer\Adapter;

use Zend\Json\Encoder;
use Zend\Serializer;
use ZendTest\Serializer\TestAsset\Dummy;

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

    public function tearDown()
    {
        $this->adapter = null;
    }

    public function testSerializeObject()
    {
        $object = new Dummy();
        $expected = Encoder::encode($object);

        $data = $this->adapter->serialize($object);

        $this->assertNotEmpty($data);
        $this->assertEquals($expected, $data);
    }

    public function testUnserializeObject()
    {
        $expected = new Dummy();

        $serialized = Encoder::encode($expected);
        $data = $this->adapter->unserialize($serialized);

        $this->assertInstanceOf(get_class($expected), $data);
    }

    /**
     * @dataProvider dataProviderWithScenarios
     */
    public function testPhpCode($value, $expected)
    {
        // $value serialized should be same as $expected
        $serializeValue = $this->adapter->serialize($value);
        $this->assertEquals($serializeValue, $expected);

        // $expected unserialized should be same as $value
        $unserializeValue = $this->adapter->unserialize($expected);
        $this->assertEquals($unserializeValue, $value);
    }

    public function dataProviderWithScenarios()
    {
        return [
            'Serialize String' => [
                'value' => 'test',
                'expected' => serialize('test')
            ],
            'Serialize PHP Code with tags' => [
                'value' => '<?php echo "test"; ?>',
                'expected' => serialize('<?php echo "test"; ?>')
            ],
            'Serialize boolean true' => [
                'value' => true,
                'expected' => serialize(true)
            ],
            'Serialize boolean false' => [
                'value' => false,
                'expected' => serialize(false)
            ],
            'Serialize type null' => [
                'value' => null,
                'expected' => serialize(null)
            ],
            'Serialize number' => [
                'value' => 100.12345,
                'expected' => serialize(100.12345)
            ],
            // Boolean as string
            'Unserialize same value boolean as string' => [
                'value' => 'false',
                'expected' => serialize('false')
            ],
        ];
    }
}
