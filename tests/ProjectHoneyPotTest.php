<?php
namespace joshtronic\Tests;
use joshtronic\ProjectHoneyPot;
use PHPUnit\Framework\TestCase;

class ProjectHoneyPotTest extends TestCase
{
    public function testInvalidKey()
    {
        try {
            new ProjectHoneyPot('foo');
        } catch (\Exception $e) {
            $this->assertSame('You must specify a valid API key.', $e->getMessage());
        }
    }

    public function testInvalidIP()
    {
        $object = new ProjectHoneyPot('foobarfoobar');

        $this->assertEquals(
            array('error' => 'Invalid IP address.'),
            $object->query('foo')
        );
    }

    public function testMissingResults()
    {
        $mock = $this->getMockBuilder('joshtronic\\ProjectHoneyPot')
            ->setConstructorArgs(array('foobarfoobar'))
            ->setMethods(array('dns_get_record'))
            ->getMock();

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue('foo'));

        $this->assertFalse($mock->query('1.2.3.4'));
    }

    public function testCategory0()
    {
        $mock = $this->getMockBuilder('joshtronic\\ProjectHoneyPot')
            ->setConstructorArgs(array('foobarfoobar'))
            ->setMethods(array('dns_get_record'))
            ->getMock();

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue(array(array('ip' => '127.0.0.0'))));

        $results = $mock->query('1.2.3.4');

        $this->assertEquals(array('Search Engine'), $results['categories']);
    }

    public function testCategory1()
    {
        $mock = $this->getMockBuilder('joshtronic\\ProjectHoneyPot')
            ->setConstructorArgs(array('foobarfoobar'))
            ->setMethods(array('dns_get_record'))
            ->getMock();

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue(array(array('ip' => '127.0.0.1'))));

        $results = $mock->query('1.2.3.4');

        $this->assertEquals(array('Suspicious'), $results['categories']);
    }

    public function testCategory2()
    {
        $mock = $this->getMockBuilder('joshtronic\\ProjectHoneyPot')
            ->setConstructorArgs(array('foobarfoobar'))
            ->setMethods(array('dns_get_record'))
            ->getMock();

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue(array(array('ip' => '127.0.0.2'))));

        $results = $mock->query('1.2.3.4');

        $this->assertEquals(array('Harvester'), $results['categories']);
    }

    public function testCategory3()
    {
        $mock = $this->getMockBuilder('joshtronic\\ProjectHoneyPot')
            ->setConstructorArgs(array('foobarfoobar'))
            ->setMethods(array('dns_get_record'))
            ->getMock();

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue(array(array('ip' => '127.0.0.3'))));

        $results = $mock->query('1.2.3.4');

        $this->assertEquals(
            array('Suspicious', 'Harvester'),
            $results['categories']
        );
    }

    public function testCategory4()
    {
        $mock = $this->getMockBuilder('joshtronic\\ProjectHoneyPot')
            ->setConstructorArgs(array('foobarfoobar'))
            ->setMethods(array('dns_get_record'))
            ->getMock();

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue(array(array('ip' => '127.0.0.4'))));

        $results = $mock->query('1.2.3.4');

        $this->assertEquals(
            array('Comment Spammer'),
            $results['categories']
        );
    }

    public function testCategory5()
    {
        $mock = $this->getMockBuilder('joshtronic\\ProjectHoneyPot')
            ->setConstructorArgs(array('foobarfoobar'))
            ->setMethods(array('dns_get_record'))
            ->getMock();

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue(array(array('ip' => '127.0.0.5'))));

        $results = $mock->query('1.2.3.4');

        $this->assertEquals(
            array('Suspicious', 'Comment Spammer'),
            $results['categories']
        );
    }

    public function testCategory6()
    {
        $mock = $this->getMockBuilder('joshtronic\\ProjectHoneyPot')
            ->setConstructorArgs(array('foobarfoobar'))
            ->setMethods(array('dns_get_record'))
            ->getMock();

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue(array(array('ip' => '127.0.0.6'))));

        $results = $mock->query('1.2.3.4');

        $this->assertEquals(
            array('Harvester', 'Comment Spammer'),
            $results['categories']
        );
    }

    public function testCategory7()
    {
        $mock = $this->getMockBuilder('joshtronic\\ProjectHoneyPot')
            ->setConstructorArgs(array('foobarfoobar'))
            ->setMethods(array('dns_get_record'))
            ->getMock();

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue(array(array('ip' => '127.0.0.7'))));

        $results = $mock->query('1.2.3.4');

        $this->assertEquals(
            array('Suspicious', 'Harvester', 'Comment Spammer'),
            $results['categories']
        );
    }

    public function testCategoryDefault()
    {
        $mock = $this->getMockBuilder('joshtronic\\ProjectHoneyPot')
            ->setConstructorArgs(array('foobarfoobar'))
            ->setMethods(array('dns_get_record'))
            ->getMock();

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue(array(array('ip' => '127.0.0.255'))));

        $results = $mock->query('1.2.3.4');

        $this->assertEquals(
            array('Reserved for Future Use'),
            $results['categories']
        );
    }

    public function testWithout127()
    {
        $mock = $this->getMockBuilder('joshtronic\\ProjectHoneyPot')
            ->setConstructorArgs(array('foobarfoobar'))
            ->setMethods(array('dns_get_record'))
            ->getMock();

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue(array(array('ip' => '1.0.0.0'))));

        $this->assertFalse($mock->query('1.2.3.4'));
    }

    // Doesn't serve much purpose aside from helping achieve 100% coverage
    public function testDnsGetRecord()
    {
        $object = new ProjectHoneyPot('foobarfoobar');

        $result = $object->dns_get_record('1.2.3.4');

        $this->assertEquals(array(), $result);
    }
}

