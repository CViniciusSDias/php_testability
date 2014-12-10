<?php
namespace edsonmedina\php_testability\NodeVisitors;
use edsonmedina\php_testability\ReportDataInterface;
use edsonmedina\php_testability\NodeWrapper;
use edsonmedina\php_testability\AnalyserScope;

use PhpParser;
use PhpParser\Node\Expr;

class MethodVisitor extends PhpParser\NodeVisitorAbstract
{
    private $data;
    private $scope;

    public function __construct (ReportDataInterface $data, AnalyserScope $scope)
    {
        $this->data  = $data;
        $this->scope = $scope;
    }

    public function enterNode (PhpParser\Node $node) 
    {
        $obj = new NodeWrapper ($node);

        if ($obj->isMethod()) 
        {
            $this->scope->startMethod ($obj->getName());
            $this->data->saveScopePosition ($this->scope->getScopeName(), $obj->line);

            if ($node->isPrivate()) 
            {
                $this->data->addIssue ($obj->line, 'private_method', $this->scope->getScopeName(), $obj->getName());
            }
            elseif ($node->isProtected()) 
            {
                $this->data->addIssue ($obj->line, 'protected_method', $this->scope->getScopeName(), $obj->getName());
            }
        }
    }

    public function leaveNode (PhpParser\Node $node) 
    {
        $obj = new NodeWrapper ($node);

        // end of method or global function
        if ($obj->isMethod()) 
        {
            $this->scope->endMethod();
        }
    }
}
