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

	public function testConstruct() {
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

    /**
     * @depends testRaw
     */
    public function testGetActivePage(){
        $xBoilerplate = new xBoilerplate('/ajax/test');
        $this->assertEquals('active',$xBoilerplate->getActive('/'.$xBoilerplate->_page) );
    }

    public function testGetPath_NoVersion(){
        $xBoilerplate = new xBoilerplate('/');
        $this->assertEquals('/img/',$xBoilerplate->img());
        $this->assertEquals('/css/',$xBoilerplate->css());
        $this->assertEquals('/js/',$xBoilerplate->js());
    }

    /**
     * @depends testGetPath_NoVersion
     */
    public function testGetPath_WithVersion(){
        $xBoilerplate = new xBoilerplate('/');
        $xBoilerplate->getConfig()->version = '1';
        $this->assertEquals('/img/1/',$xBoilerplate->img());
        $this->assertEquals('/css/1/',$xBoilerplate->css());
        $this->assertEquals('/js/1/',$xBoilerplate->js());
    }


    public function testLoadComponent(){
        $xBoilerplate = new xBoilerplate('/');
        $this->assertContains("This is a component",$xBoilerplate->loadComponent("test"));
    }

    public function testLoadLayout() {
//        $regex = '';
//
//        $xBoilerplate = new xBoilerplate('/');
//        $this->expectOutputRegex($regex, $xBoilerplate->loadLayout('template.php'));

    }

    public function testLoadCss() {
        $xBoilerplate = new xBoilerplate('/');
        $this->assertEquals('<link type="text/css" rel="stylesheet" href="/css/style.css">', $xBoilerplate->loadPageCss());
    }

    public function testCssFileExists() {
        $this->assertFileExists('/vagrant/httpdocs/css/reset.css', 'File reset.css doesnt exist');
        $this->assertFileExists('/vagrant/httpdocs/css/style.css', 'File style.css doesnt exist');
    }

    public function testJsFileExists() {

    }




}