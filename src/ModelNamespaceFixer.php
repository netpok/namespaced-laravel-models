<?php

namespace Netpok\NamespacedLaravelModels;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;

class ModelNamespaceFixer
{
    /**
     * The root namespace of the Laravel project.
     *
     * @var string
     */
    protected $rootNamespace;

    /**
     * The model namespace under the root namespace.
     *
     * @var string
     */
    protected $modelNamespace;

    /**
     * ModelNamespaceFixer constructor.
     *
     * @param  string  $rootNamespace
     * @param  string  $modelNamespace
     */
    public function __construct(string $rootNamespace, string $modelNamespace)
    {
        $this->rootNamespace = $rootNamespace;
        $this->modelNamespace = $modelNamespace;
    }

    /**
     * Sets the model namespace in the command input if required.
     *
     * @param  string  $command
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     */
    public function fixInput(string $command, InputInterface $input): void
    {
        switch ($command) {
            case 'make:model':
                $this->handleArgument($input);
                break;
            case 'make:controller':
                $this->handleOption($input, 'parent');
                // no break
            case 'make:factory':
            case 'make:observer':
            case 'make:policy':
                $this->handleOption($input, 'model');
                break;
            default:
                throw new InvalidArgumentException(
                    sprintf('Command [%s] not supported', $command)
                );
        }
    }

    /**
     * Sets the model namespace in the name argument.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     */
    protected function handleArgument(InputInterface $input): void
    {
        $input->setArgument(
            'name',
            $this->prefixClass($input->getArgument('name'))
        );
    }

    /**
     * Sets the namespace
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  string  $name
     */
    protected function handleOption(InputInterface $input, string $name): void
    {
        if ($option = $input->getOption($name)) {
            $input->setOption($name, $this->prefixClass($option));
        }
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function prefixClass(string $name): string
    {
        $name = ltrim($name, '\\/');

        if (Str::startsWith($name, $this->rootNamespace)) {
            return $name;
        }

        $name = $this->modelNamespace.'\\'.str_replace('/', '\\', $name);

        return '\\'.trim($this->rootNamespace, '\\').'\\'.$name;
    }
}
