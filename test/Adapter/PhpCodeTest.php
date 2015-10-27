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
 * @group      Zend_Serializer
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
     * @dataProvider dataProvider
     */
    public function testPhpCode($value, $expected, $serialize)
    {
        if ($serialize) {
            $data = $this->adapter->serialize($value);
        } else {
            $data = $this->adapter->unserialize($value);
        }

        $this->assertEquals($expected, $data);
    }

    public function dataProvider()
    {
        return [
            [
                'value' => 'test',
                'expected' => serialize('test'),
                'serialize' => true
            ],
            [
                'value' => '<?php echo "test"; ?>',
                'expected' => serialize('<?php echo "test"; ?>'),
                'serialize' => true
            ],
            [
                'value' => 'test',
                'expected' => serialize('test'),
                'serialize' => true
            ],
            [
                'value' => true,
                'expected' => serialize(true),
                'serialize' => true
            ],
            [
                'value' => false,
                'expected' => serialize(false),
                'serialize' => true
            ],
            [
                'value' => null,
                'expected' => serialize(null),
                'serialize' => true
            ],
            [
                'value' => 100.12345,
                'expected' => serialize(100.12345),
                'serialize' => true
            ],
            [
                'value' => serialize('test'),
                'expected' => 'test',
                'serialize' => false
            ],
            // Boolean as string
            [
                'value' => 'false',
                'expected' => 'false',
                'serialize' => false
            ],
            // Random code
            [
                'value' => serialize('<?php echo "test"; ?>'),
                'expected' => '<?php echo "test"; ?>',
                'serialize' => false
            ],
            // Booleans
            [
                'value' => true,
                'expected' => true,
                'serialize' => false
            ],
            [
                'value' => false,
                'expected' => false,
                'serialize' => false
            ],
            [
                'value' => 'null',
                'expected' => 'null',
                'serialize' => false
            ],
            [
                'value' => '100',
                'expected' => '100',
                'serialize' => false
            ],
        ];
    }
}
