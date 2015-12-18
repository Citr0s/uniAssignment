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
		$this->assertTrue($name->hasError());
	}

	public function testNameSuccess()
	{
		$name = new NameValidator('toomanycharacters--------');
		$this->assertFalse($name->hasError());
	}

	public function testNameRequired()
	{
		$email = new NameValidator('', true);
		$this->assertEquals('This is a required field', $email->getError());
	}

	public function testUsernameFail()
	{
		$name = new UsernameValidator('toomanycharacters---------');
		$this->assertTrue($name->hasError());
	}

	public function testUsernameSuccess()
	{
		$name = new UsernameValidator('exactlyrightamount--');
		$this->assertFalse($name->hasError());
	}

	public function testUsernameRequired()
	{
		$email = new UsernameValidator('', true);
		$this->assertEquals('This is a required field', $email->getError());
	}

	public function testPasswordFail()
	{
		$name = new PasswordValidator('toomanycharacters---------');
		$this->assertTrue($name->hasError());
	}

	public function testPasswordSuccess()
	{
		$name = new PasswordValidator('exactlyrightamount--');
		$this->assertFalse($name->hasError());
	}

	public function testPasswordRequired()
	{
		$age = new PasswordValidator('', true);
		$this->assertEquals('This is a required field', $age->getError());
	}

	public function testAgeFailTooLow()
	{
		$age = new AgeValidator('20', false, 20, 45);
		$this->assertTrue($age->hasError());
	}

	public function testAgeFailTooHigh()
	{
		$age = new AgeValidator('45', false, 20, 45);
		$this->assertTrue($age->hasError());
	}

	public function testAgeSuccessLowBoundary()
	{
		$age = new AgeValidator('21', false, 20, 45);
		$this->assertFalse($age->hasError());
	}

	public function testAgeSuccessHighBoundary()
	{
		$age = new AgeValidator('44', false, 20, 45);
		$this->assertFalse($age->hasError());
	}

	public function testAgeRequired()
	{
		$age = new AgeValidator('', true);
		$this->assertEquals('This is a required field', $age->getError());
	}

	public function testDateFailTooHigh()
	{
		$age = new DateValidator('12-12-2100');
		$this->assertTrue($age->hasError());
	}

	public function testDateSuccessHighBoundary()
	{
		$age = new DateValidator('1-1-1997');
		$this->assertFalse($age->hasError());
	}

	public function testDateRequired()
	{
		$age = new DateValidator('', true);
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