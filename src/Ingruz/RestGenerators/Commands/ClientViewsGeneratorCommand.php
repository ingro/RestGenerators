<?php
namespace Ingruz\RestGenerators\Commands;

use Ingruz\RestGenerators\Generators\ClientViewsGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ClientViewsGeneratorCommand extends BaseGeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'restgenerators:generate:clientViews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a client views file.';

    /**
     * Model generator instance.
     *
     * @var Ingruz\RestGenerators\Generators\ClientViewsGenerator
     */
    protected $generator;

    /**
     * Create a new command instance.
     *
     * @param ClientViewsGenerator $generator
     */
    public function __construct(ClientViewsGenerator $generator)
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
        $path = (! empty($optionPath)) ? $this->option('path') : $this->laravel['config']->get('rest-generators::paths.clientViews');

        return $path . '/' . $this->argument('name') . '/' . $this->argument('name') . '_views.coffee';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'Name of the client module views to generate.'),
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
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path to the client module views directory.', ''),
            array('template', null, InputOption::VALUE_OPTIONAL, 'Path to template.', __DIR__.'/../Generators/templates/frontend/moduleViews.twig')
        );
    }
}