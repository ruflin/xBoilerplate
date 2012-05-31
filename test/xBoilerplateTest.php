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
        PrivateTestXBoilerplate::resetInstance();
	}

	public function testConstruct() {
        $xBoilerplate = xBoilerplate::getInstance()->pagestart('/test');
		$this->assertInstanceOf('xBoilerplate', $xBoilerplate);
	}

	public function testGetConfig() {
        $xBoilerplate = xBoilerplate::getInstance()->pagestart('/');
		$this->assertTrue($xBoilerplate->getConfig()->dev);
		$this->assertFalse($xBoilerplate->getConfig()->raw);
	}

	public function testRaw() {
        $xBoilerplate = xBoilerplate::getInstance()->pagestart('/ajax/test');
		$this->assertEquals('Ajax Test', $xBoilerplate->render());
		$this->assertTrue($xBoilerplate->getConfig()->raw);
	}

    /**
     * @depends testRaw
     */
    public function testGetActivePage(){
        $xBoilerplate = xBoilerplate::getInstance()->pagestart('/ajax/test');
        $this->assertEquals('active',$xBoilerplate->getActive('/'.$xBoilerplate->_page) );
    }

    public function testGetPath_NoVersion(){
        $xBoilerplate = xBoilerplate::getInstance()->pagestart('/');
        $this->assertEquals('/img/',$xBoilerplate->img());
        $this->assertEquals('/css/',$xBoilerplate->css());
        $this->assertEquals('/js/',$xBoilerplate->js());
    }

    /**
     * @depends testGetPath_NoVersion
     */
    public function testGetPath_WithVersion(){
        $xBoilerplate = xBoilerplate::getInstance()->pagestart('/');
        $xBoilerplate->getConfig()->version = '1';
        $this->assertEquals('/img/1/',$xBoilerplate->img());
        $this->assertEquals('/css/1/',$xBoilerplate->css());
        $this->assertEquals('/js/1/',$xBoilerplate->js());
    }


    public function testLoadComponent(){
        $xBoilerplate = xBoilerplate::getInstance()->pagestart('/');
        $this->assertContains("This is a component",$xBoilerplate->loadComponent("test"));
    }




}

/**
 * Simple class that provides a method to reset the singleton to it's an un-instantiated state.
 *
 *
 * @author Oliver Tupman <oliver.tupman@centralway.com>
 * Date: 31/05/2012
 * Time: 11:57
 */
class PrivateTestXBoilerplate extends xBoilerplate
{
    public static function resetInstance() {
        self::$_instance = null;
    }
}
