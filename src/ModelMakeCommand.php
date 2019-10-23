<?php

namespace Netpok\NamespacedLaravelModels;

use Illuminate\Foundation\Console\ModelMakeCommand as BaseCommand;

class ModelMakeCommand extends BaseCommand
{
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Models';
    }
}
