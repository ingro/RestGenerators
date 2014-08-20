<?php
namespace Ingruz\RestGenerators\Generators;

use Config;

class ModelGenerator extends BaseGenerator {

    /**
     * Compile template and generate
     *
     * @param  string $path
     * @param  string $template Path to template
     * @return boolean
     */
    public function make($path, $template)
    {
        $this->name = $this->getBaseName($path);
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

        $loader = new \Twig_Loader_String();

        $twig = new \Twig_Environment($loader);

        $namespace = Config::get('rest::namespace');

        return $twig->render($this->template, [
            'className' => $className,
            'namespace' => $namespace
        ]);
    }
}