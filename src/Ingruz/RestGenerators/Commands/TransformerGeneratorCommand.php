<?php
namespace Ingruz\RestGenerators\Commands;

use Ingruz\RestGenerators\Generators\TransformerGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class TransformerGeneratorCommand extends BaseGeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'restgenerators:generate:transformer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a transformer file.';

    /**
     * Transformer generator instance.
     *
     * @var Ingruz\RestGenerators\Generators\TransformerGenerator
     */
    protected $generator;

    /**
     * Create a new command instance.
     *
     * @param TransformerGenerator $generator
     */
    public function __construct(TransformerGenerator $generator)
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
        $path = (! empty($optionPath)) ? $this->option('path') : $this->laravel['config']->get('rest-generators::paths.transformer');

        return $path . '/' . ucwords($this->argument('name')) . 'Transformer.php';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'Name of the transformer to generate.'),
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
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path to the transformer directory.', ''),
            array('template', null, InputOption::VALUE_OPTIONAL, 'Path to template.', __DIR__.'/../Generators/templates/backend/transformer.twig')
        );
    }
}