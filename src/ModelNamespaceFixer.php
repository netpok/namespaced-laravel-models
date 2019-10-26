<?php

namespace Netpok\NamespacedLaravelModels;

use InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;

class ModelNamespaceFixer
{
    protected $rootNamespace;
    protected $modelNamespace;

    public function __construct($rootNamespace, $modelNamespace){
        $this->rootNamespace = $rootNamespace;
        $this->modelNamespace = $modelNamespace;
    }

    public function fixInput(string $command, InputInterface $input): void
    {
        switch($command){
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

    protected function handleArgument(InputInterface $input): void
    {
        $input->setArgument(
            'name',
            dump($this->prefixClass($input->getArgument('name')))
        );
    }

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

        if (\Str::startsWith($name, $this->rootNamespace)) {
            return $name;
        }

        $name = $this->modelNamespace.'\\'.str_replace('/', '\\', $name);

        return trim($this->rootNamespace, '\\').'\\'.$name;
    }
}
