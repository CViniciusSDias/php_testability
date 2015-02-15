<?php

require_once __DIR__.'/../../vendor/autoload.php';
use edsonmedina\php_testability\NodeVisitors\SuperGlobalVisitor;
use edsonmedina\php_testability\Contexts\RootContext;
use edsonmedina\php_testability\ContextStack;

class SuperGlobalVisitorTest extends PHPUnit_Framework_TestCase
{
	public function setup ()
	{
		$this->context = new RootContext ('/');

		$this->stack = $this->getMockBuilder ('edsonmedina\php_testability\ContextStack')
		                    ->setConstructorArgs(array($this->context))
		                    ->setMethods(array('addIssue'))
		                    ->getMock();

		$this->wrongNode = $this->getMockBuilder ('PhpParser\Node\Expr\StaticCall')
		                        ->disableOriginalConstructor()
		                        ->getMock();

		$this->visitor = $this->getMockBuilder ('edsonmedina\php_testability\NodeVisitors\SuperGlobalVisitor')
		                      ->setConstructorArgs(array($this->stack, $this->context))
		                      ->setMethods(array('inGlobalScope'))
		                      ->getMock();
	}

	/**
	 * @covers edsonmedina\php_testability\NodeVisitors\SuperGlobalVisitor::leaveNode
	 */
	public function testLeaveNodeWithDifferentType ()
	{
		$this->stack->expects($this->never())->method('addIssue');

		$visitor = new SuperGlobalVisitor ($this->stack, $this->context);
		$visitor->leaveNode ($this->wrongNode);
	}

	/**
	 * @covers edsonmedina\php_testability\NodeVisitors\SuperGlobalVisitor::leaveNode
	 */
	public function testLeaveNodeInGlobalSpace ()
	{
		$this->stack->expects($this->never())->method('addIssue');

		$this->stack->method ('inGlobalScope')->willReturn (true);

		$node = $this->getMockBuilder ('PhpParser\Node\Expr\ArrayDimFetch')
		             ->disableOriginalConstructor()
		             ->getMock();

		$this->visitor->leaveNode ($node);
	}
}
