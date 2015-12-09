<?php
namespace Assignment;

use mysqli;

class TestValidation extends \PHPUnit_Framework_TestCase {

	public function testEmailFail()
	{
		$email = new EmailValidator('notanemail');
		$this->assertEquals(true, $email->hasError());
	}

	public function testEmailSuccess()
	{
		$email = new EmailValidator('me@here.com');
		$this->assertEquals(false, $email->hasError());
	}

	public function testEmailRequired()
	{
		$email = new EmailValidator('', true);
		$this->assertEquals('This is a required field', $email->getError());
	}

	public function testNameFail()
	{
		$name = new NameValidator('toomanycharacters---------');
		$this->assertEquals(true, $name->hasError());
	}

	public function testNameSuccess()
	{
		$name = new NameValidator('toomanycharacters--------');
		$this->assertFalse($name->hasError());
	}

	public function testNameRequired()
	{
		$age = new NameValidator('', true);
		$this->assertEquals('This is a required field', $age->getError());
	}

	public function testAgeFailTooLow()
	{
		$age = new AgeValidator('20');
		$this->assertTrue($age->hasError());
	}

	public function testAgeFailTooHigh()
	{
		$age = new AgeValidator('45');
		$this->assertTrue($age->hasError());
	}

	public function testAgeSuccessLowBoundary()
	{
		$age = new AgeValidator('21');
		$this->assertFalse($age->hasError());
	}

	public function testAgeSuccessHighBoundary()
	{
		$age = new AgeValidator('44');
		$this->assertFalse($age->hasError());
	}

	public function testAgeRequired()
	{
		$age = new AgeValidator('', true);
		$this->assertEquals('This is a required field', $age->getError());
	}

	public function testSet()
	{
		$valSet = new ValidatorSet();
		$valSet->addItem(new EmailValidator('notanemail'), 'email');
		$email = $valSet->getItem('email');
		$this->assertTrue($email->hasError());
	}

	public function testSetReturnErrors()
	{
		$valSet = new ValidatorSet();
		$valSet->addItem(new EmailValidator('notanemail'), 'email1');
		$valSet->addItem(new EmailValidator('me@here.com'), 'email2');
		$expected = array('email1'=>'Not a valid email address');
		$this->assertEquals($expected, $valSet->getErrors());
	}
}