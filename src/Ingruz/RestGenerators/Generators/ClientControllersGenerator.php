<?php
namespace Ingruz\RestGenerators\Generators;

use Twig_Environment;
use Twig_Loader_String;

class ClientControllersGenerator extends BaseGenerator {

    /**
     * @var
     */
    protected $name;

    /**
     * Compile template and generate
     *
     * @param  string $path
     * @param  string $template Path to template
     * @param  string $name
     * @return boolean
     */
    public function makeWithName($path, $template, $name)
    {
        $this->name = $name;

        $keys = array_keys($path);

        for($i = 0; $i < count($keys); $i++)
        {
            $result = $this->makeSingleFile($path[$keys[$i]], $template[$keys[$i]]);

            if (! $result)
            {
                break;
            }
        }

        return $result;
    }

    protected function makeSingleFile($path, $template)
    {
//        $this->name = $this->getBaseName($path);
        $this->path = $this->getPath($path);
        $template = $this->getTemplate($template, $this->name);

        if (! $this->file->exists($this->path))
        {
            if (! $this->file->isWritable($this->path))
            {
                $this->file->makeDirectory(dirname($this->path));
            }

            return $this->file->put($this->path, $template) !== false;
        }

        return false;
    }

    /**
     * Fetch the compiled template for a model
     *
     * @param  string $template Path to template
     * @param  string $className
     * @return string Compiled template
     */
    protected function getTemplate($template, $className)
    {
        $this->template = $this->file->get($template);

        $loader = new Twig_Loader_String();

        $twig = new Twig_Environment($loader);

        return $twig->render($this->template, ['className' => $className]);
    }

    protected function getBaseName($path)
    {
        return basename($path, '.coffee');
    }
}