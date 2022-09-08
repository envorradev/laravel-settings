<?php

namespace Envorra\LaravelSettings\Resolvers;

use Exception;
use SplFileInfo;
use SplFileObject;
use PhpParser\Node;
use PhpParser\Parser;
use PhpParser\NodeVisitor;
use PhpParser\ParserFactory;
use PhpParser\NodeTraverser;
use Envorra\LaravelSettings\Resolvers\NodeVisitors\ClassQualifier;

/**
 * ClassResolver
 *
 * @package Envorra\LaravelSettings\Resolvers
 */
class ClassResolver
{
    /**
     * @var ClassQualifier
     */
    protected ClassQualifier $classQualifier;
    /**
     * @var array<Node>
     */
    protected array $nodes;
    /**
     * @var Parser
     */
    protected Parser $parser;
    /**
     * @var NodeTraverser
     */
    protected NodeTraverser $traverser;

    /**
     * @param  SplFileObject  $file
     * @throws Exception
     */
    public function __construct(protected SplFileObject $file)
    {
        $this->classQualifier = new ClassQualifier();
        $this->nodes = $this->traverse();
    }

    /**
     * @throws Exception
     */
    public static function make(SplFileObject|SplFileInfo|string $file): self
    {
        if (!$file instanceof SplFileObject) {
            $file = $file instanceof SplFileInfo ? $file->openFile() : new SplFileObject($file);
        }

        return new self($file);
    }

    /**
     * @param  SplFileObject|SplFileInfo|string  $file
     * @return string|null
     */
    public static function resolve(SplFileObject|SplFileInfo|string $file): ?string
    {
        try {
            return static::make($file)->getFullyQualifiedName();
        } catch (Exception) {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->classQualifier->getClass();
    }

    /**
     * @return ClassQualifier
     */
    public function getClassQualifier(): ClassQualifier
    {
        return $this->classQualifier;
    }

    /**
     * @return string
     */
    public function getFullyQualifiedName(): string
    {
        return $this->classQualifier->getFullyQualifiedClass();
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->classQualifier->getNamespace();
    }

    /**
     * @return array<Node>
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }

    /**
     * @return array
     */
    protected function abstractSyntaxTree(): array
    {
        return $this->parser()->parse($this->fileContents());
    }

    /**
     * @return string
     */
    protected function fileContents(): string
    {
        return $this->file->fread($this->file->getSize());
    }

    /**
     * @return void
     */
    protected function initializeNodeTraverser(): void
    {
        $this->traverser = new NodeTraverser();

        foreach ($this->visitors() as $visitor) {
            $this->traverser->addVisitor($visitor);
        }
    }

    /**
     * @return void
     */
    protected function initializeParser(): void
    {
        $factory = new ParserFactory();
        $this->parser = $factory->create($this->parserFactoryKind());
    }

    /**
     * @return Parser
     */
    protected function parser(): Parser
    {
        if (!isset($this->parser)) {
            $this->initializeParser();
        }

        return $this->parser;
    }

    /**
     * @return int
     */
    protected function parserFactoryKind(): int
    {
        return ParserFactory::PREFER_PHP7;
    }

    /**
     * @return array
     */
    protected function traverse(): array
    {
        return $this->traverser()->traverse($this->abstractSyntaxTree());
    }

    /**
     * @return NodeTraverser
     */
    protected function traverser(): NodeTraverser
    {
        if (!isset($this->traverser)) {
            $this->initializeNodeTraverser();
        }

        return $this->traverser;
    }

    /**
     * @return array<NodeVisitor>
     */
    protected function visitors(): array
    {
        return [$this->classQualifier];
    }
}
