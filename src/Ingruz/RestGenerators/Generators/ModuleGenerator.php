<?php
namespace Ingruz\RestGenerators\Generators;

use Illuminate\Filesystem\Filesystem as File;
use Ingruz\RestGenerators\Cache;
use Config;

/**
 * @property mixed template
 */
class ModuleGenerator {

    /**
     * Maps possible field types to matching Doctrine types
     * @var array
     */
    protected $registerTypes = array();

    /**
     * File system instance
     * @var File
     */
    protected $file;

    /**
     * Cache istance
     * @var Cache
     */
    protected $cache;

    /**
     * Constructor
     *
     * @param File $file
     * @param Cache $cache
     */
    public function __construct(File $file, Cache $cache)
    {
        $this->file = $file;
        $this->cache = $cache;
    }

    /**
     * Update app/routes.php
     *
     * @param  string $name
     * @return void
     */
    public function updateRoutesFile($name)
    {
//        $name = strtolower(Pluralizer::plural($name));

        $namespace = Config::get('rest::namespace');

        $this->file->append(
            app_path() . '/routes.php',
            "\n\nRoute::resource('" . $name . "', '". $namespace ."\\Controllers\\" . ucwords($name) . "Controller');"
        );
    }

    /**
     * @param $name
     */
    public function buildCache($name)
    {
        $table = $this->getModelTableName($name);
        $connection = $this->getModelConnection($name);

        $fields = $this->detectColumns($table, $connection);

        $this->cache->fields($fields);
    }

    /**
     *
     */
    public function emptyCache()
    {
        $this->cache->destroyAll();
    }

    /**
     * @param $name
     */
    protected function getModelTableName($name)
    {
        $modelName = $this->getModelClassName($name);
        $istance = new $modelName;

        return $istance->getTable();
    }

    protected function getModelConnection($name)
    {
        $modelName = $this->getModelClassName($name);
        $istance = new $modelName;

        return $istance->getConnectionName();
    }

    protected function getModelClassName($name)
    {
        $namespace = Config::get('rest::namespace');
        return $namespace.'\\Models\\'.ucfirst($name);
    }

    /**
     * @param string $table
     * @param string $connection
     * @return array
     */
    protected function detectColumns($table, $connection){

        $fields = array();

        $schema = \DB::connection($connection)->getDoctrineSchemaManager($table);

        foreach ($this->registerTypes as $convertFrom=>$convertTo) {
            $schema->getDatabasePlatform()->registerDoctrineTypeMapping($convertFrom, $convertTo);
        }

        $indexes = $schema->listTableIndexes($table);
        foreach ($indexes as $index) {
            if($index->isUnique()){
                $unique[$index->getName()] = true;
            }
        }

        $columns = $schema->listTableColumns($table);

        if($columns){
            foreach ($columns as $column) {
                $name = $column->getName();
                $type =  $column->getType()->getName();
//                $length = $column->getLength();
//                $default = $column->getDefault();
                if(isset($this->fieldTypeMap[$type])) {
                    $type = $this->fieldTypeMap[$type];
                }
                if(!in_array($name, array('id', 'created_at', 'updated_at'))){
                    /*$field = "$name:$type";
                    if($length){
                        $field .= "[$length]";
                    }
                    if(!$column->getNotNull()){
                        $field .= ':nullable';
                    }
                    if(isset($unique[$name])){
                        $field .= ':unique';
                    }*/
                    $fields[$name] = $type;
                }
            }
        }
//        return implode(', ', $fields);
        return $fields;
    }
}