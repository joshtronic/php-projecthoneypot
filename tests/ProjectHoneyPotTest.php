<?php

require_once '../src/ProjectHoneyPot.php';

class ProjectHoneyPotTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException        Exception
     * @expectedExceptionMessage You must specify a valid API key.
     */
    public function testInvalidKey()
    {
        new joshtronic\ProjectHoneyPot('foo');
    }

    public function testInvalidIP()
    {
        $object = new joshtronic\ProjectHoneyPot('foobarfoobar');

        $this->assertEquals(
            array('error' => 'Invalid IP address.'),
            $object->query('foo')
        );
    }

    public function testMissingResults()
    {
        $mock = $this->getMock(
            'joshtronic\ProjectHoneyPot',
            array('dns_get_record'),
            array('foobarfoobar')
        );

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue('foo'));

        $this->assertFalse($mock->query('1.2.3.4'));
    }

    public function testCategory0()
    {
        $mock = $this->getMock(
            'joshtronic\ProjectHoneyPot',
            array('dns_get_record'),
            array('foobarfoobar')
        );

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue(array(array('ip' => '127.0.0.0'))));

        $results = $mock->query('1.2.3.4');

        $this->assertEquals(array('Search Engine'), $results['categories']);
    }

    public function testCategory1()
    {
        $mock = $this->getMock(
            'joshtronic\ProjectHoneyPot',
            array('dns_get_record'),
            array('foobarfoobar')
        );

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue(array(array('ip' => '127.0.0.1'))));

        $results = $mock->query('1.2.3.4');

        $this->assertEquals(array('Suspicious'), $results['categories']);
    }

    public function testCategory2()
    {
        $mock = $this->getMock(
            'joshtronic\ProjectHoneyPot',
            array('dns_get_record'),
            array('foobarfoobar')
        );

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue(array(array('ip' => '127.0.0.2'))));

        $results = $mock->query('1.2.3.4');

        $this->assertEquals(array('Harvester'), $results['categories']);
    }

    public function testCategory3()
    {
        $mock = $this->getMock(
            'joshtronic\ProjectHoneyPot',
            array('dns_get_record'),
            array('foobarfoobar')
        );

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
        $mock = $this->getMock(
            'joshtronic\ProjectHoneyPot',
            array('dns_get_record'),
            array('foobarfoobar')
        );

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
        $mock = $this->getMock(
            'joshtronic\ProjectHoneyPot',
            array('dns_get_record'),
            array('foobarfoobar')
        );

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
        $mock = $this->getMock(
            'joshtronic\ProjectHoneyPot',
            array('dns_get_record'),
            array('foobarfoobar')
        );

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
        $mock = $this->getMock(
            'joshtronic\ProjectHoneyPot',
            array('dns_get_record'),
            array('foobarfoobar')
        );

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
        $mock = $this->getMock(
            'joshtronic\ProjectHoneyPot',
            array('dns_get_record'),
            array('foobarfoobar')
        );

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
        $mock = $this->getMock(
            'joshtronic\ProjectHoneyPot',
            array('dns_get_record'),
            array('foobarfoobar')
        );

        $mock->expects($this->once())
             ->method('dns_get_record')
             ->will($this->returnValue(array(array('ip' => '1.0.0.0'))));

        $this->assertFalse($mock->query('1.2.3.4'));
    }

    // Doesn't serve much purpose aside from helping achieve 100% coverage
    public function testDnsGetRecord()
    {
        $object = new joshtronic\ProjectHoneyPot('foobarfoobar');

        $object->dns_get_record('1.2.3.4');
    }
}

