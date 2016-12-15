<?php
//use PHPUnit\Framework\TestCase;
use \GeorgesWebsite\INC as web;
class test extends \PHPUnit_Framework_TestCase
{
 	function testRemplissageSession()
		{
		    web\fillSession();
		   	$this->assertEquals($_SESSION['DB']['host'], "185.14.186.97");
			$this->assertEquals($_SESSION['DB']['dbname'], 'georges');
			$this->assertEquals($_SESSION['DB']['user'], 'root');
		}

	function testConnectionBDD ()
		{
			web\fillSession();
			//ConnectBDD ();
		}

	function testPrintR ()
		{
			$tab['test'] = 'test';
			$this->assertEquals(monPrint_r ($tab) , '<pre>'.print_r($tab, true).'</pre>');
		}

	function testChargeTemplate ()
		{
			$file = file('contact.template.inc.php');
			implode ('', $file);
			$this->assertEquals(implode ('', $file) , chargeTemplate ('contact'));

			global $envoi;
			chargeTemplate ('contact');
			$this->assertEquals($envoi['sous-menu'] , creeMenu(['contact' => '' ]));
		}

	function testGetData ()	
		{
			$this->assertEquals(getData('coucou', 'test') , "[coucou][test] inconnu");
		}

} 


