<?php
namespace Ingruz\RestGenerators\Commands;

use Ingruz\RestGenerators\Generators\ClientModelGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ClientModelGeneratorCommand extends BaseGeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'restgenerators:generate:clientModel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a client model file.';

    /**
     * Model generator instance.
     *
     * @var Ingruz\Generators\Generators\ClientModelGenerator
     */
    protected $generator;

    /**
     * Create a new command instance.
     *
     * @param ClientModelGenerator $generator
     */
    public function __construct(ClientModelGenerator $generator)
    {
        parent::__construct();

        $this->generator = $generator;
    }

    /**
     * Get the path to the file that should be generated.
     *
     * @return string
     */
    protected function getPath()
    {
        $optionPath = $this->option('path');
        $path = (! empty($optionPath)) ? $this->option('path') : $this->laravel['config']->get('rest-generators::paths.clientModel');

        return $path . '/' . $this->argument('name') . '.coffee';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'Name of the client model to generate.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path to the client models directory.', ''),
            array('template', null, InputOption::VALUE_OPTIONAL, 'Path to template.', __DIR__.'/../Generators/templates/frontend/entity.twig')
        );
    }
}