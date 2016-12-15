<?php
//use PHPUnit\Framework\TestCase;
class test extends \PHPUnit_Framework_TestCase
{
	function testPrintR ()
		{
			$tab['test'] = 'test';
			$this->assertEquals(monPrint_r ($tab) , '<pre>'.print_r($tab, true).'</pre>');
		}
} 



