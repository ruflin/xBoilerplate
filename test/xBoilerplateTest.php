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
        $layout = 'Gargle Blaster';
        $xBoilerplate = new xBoilerplate('/');
        $this->assertEquals($layout, $xBoilerplate->loadLayout('test.php'));
    }

    public function testLoadCss() {
        $expectedCss = '#test {background-color: red;}';
        $xBoilerplate = new xBoilerplate('/');
        $this->assertEquals($expectedCss, $xBoilerplate->loadCss('test.css'));
    }

    public function testLoadJs() {
        $js = 'alert(\'Zaphod Beeblebrox in js!\');';
        $xBoilerplate = new xBoilerplate('/');
        $this->assertEquals($js, $xBoilerplate->loadJs('test.js'));
    }

    public function testLoadMenu() {
        $menu = 'Gargle Blaster';
        $xBoilerplate = new xBoilerplate('/');
        $this->assertEquals($menu, $xBoilerplate->loadMenu('test'));
    }

    public function testCssFileExists() {
        $this->markTestIncomplete('Test Incoplete');
        $xBoilerplate = new xBoilerplate('/');
        $this->assertFileExists($xBoilerplate->css() .'reset.css', 'File reset.css doesnt exist');
        $this->assertFileExists('/css/style.css', 'File style.css doesnt exist');
    }



}