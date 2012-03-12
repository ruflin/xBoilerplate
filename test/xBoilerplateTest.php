<?php
/**
 * Test helper
 */
require_once dirname(__FILE__) . '/bootstrap.php';

class xBoilerplateTest extends PHPUnit_Framework_TestCase
{
	public function setUp() {
	}

	public function tearDown() {
	}

	public function testConstruct(){
		$xBoilerplate = new xBoilerplate('/test');
		$this->assertInstanceOf('xBoilerplate', $xBoilerplate);
	}

	public function testGetConfig() {
		$xBoilerplate = new xBoilerplate('/');
		$this->assertTrue($xBoilerplate->getConfig()->dev);
		$this->assertFalse($xBoilerplate->getConfig()->raw);
	}

	public function testRaw() {
		$xBoilerplate = new xBoilerplate('/ajax/test');
		$this->assertEquals('Ajax Test', $xBoilerplate->render());
		$this->assertTrue($xBoilerplate->getConfig()->raw);
	}
}