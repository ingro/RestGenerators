<?php
namespace Ingruz\RestGenerators\Commands;

use Ingruz\RestGenerators\Generators\RepositoryGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RepositoryGeneratorCommand extends BaseGeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'restgenerators:generate:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a repository file.';

    /**
     * Repository generator instance.
     *
     * @var \Ingruz\RestGenerators\Generators\RepositoryGenerator
     */
    protected $generator;

    /**
     * Create a new command instance.
     *
     * @param RepositoryGenerator $generator
     */
    public function __construct(RepositoryGenerator $generator)
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
        $path = (! empty($optionPath)) ? $this->option('path') : $this->laravel['config']->get('rest-generators::paths.repository');

        return $path . '/' . ucwords($this->argument('name')) . 'Repository.php';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'Name of the repository to generate.'),
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
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path to the repositories directory.', ''),
            array('template', null, InputOption::VALUE_OPTIONAL, 'Path to template.', __DIR__.'/../Generators/templates/backend/repository.twig')
        );
    }
}