<?php

namespace Envorra\LaravelSettings\Resolvers\NodeVisitors;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Stmt\Namespace_;

/**
 * ClassQualifier
 *
 * @package Envorra\LaravelSettings\Resolvers\NodeVisitors
 */
class ClassQualifier extends NodeVisitorAbstract
{
    protected Namespace_ $namespace;

    protected Class_ $class;

    /**
     * @return Class_
     */
    public function getClassNode(): Class_
    {
        return $this->class;
    }

    /**
     * @return Namespace_
     */
    public function getNamespaceNode(): Namespace_
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class->name->name;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return implode('\\', $this->getNamespaceParts());
    }

    /**
     * @return array
     */
    public function getNamespaceParts(): array
    {
        return $this->namespace->name->parts;
    }

    /**
     * @return array
     */
    public function getFullyQualifiedClassParts(): array
    {
        return array_merge($this->getNamespaceParts(), [$this->getClass()]);
    }

    /**
     * @return string
     */
    public function getFullyQualifiedClass(): string
    {
        return implode('\\', $this->getFullyQualifiedClassParts());
    }

    /**
     * @inheritDoc
     */
    public function enterNode(Node $node): int|Node|null
    {
        if($node instanceof Namespace_) {
            $this->namespace = $node;
        } elseif($node instanceof Class_) {
            $this->class = $node;
        }
        return null;
    }
}
