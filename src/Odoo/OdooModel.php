<?php


namespace Obuchmann\OdooJsonRpc\Odoo;


use Doctrine\Common\Annotations\AnnotationReader;
use Obuchmann\OdooJsonRpc\Attributes\Model;
use Obuchmann\OdooJsonRpc\Exceptions\ConfigurationException;
use Obuchmann\OdooJsonRpc\Exceptions\OdooModelException;
use Obuchmann\OdooJsonRpc\Exceptions\UndefinedPropertyException;
use Obuchmann\OdooJsonRpc\Odoo;
use Obuchmann\OdooJsonRpc\Odoo\Mapping\HasFields;

class OdooModel
{
    use HasFields;

    /** @var Odoo */
    private static $odoo;
    
    /** @var string|null */
    private static $model = null;

    /**
     * @param Odoo $odoo
     * @return void
     */
    public static function boot(Odoo $odoo)
    {
        self::$odoo = $odoo;
    }

    /**
     * @param array|null $fields
     * @return object
     */
    public static function listFields($fields = null)
    {
        return self::$odoo->fieldsGet(static::model(), $fields);
    }

    /**
     * @param int $id
     * @return static|null
     */
    public static function find($id)
    {
        $odooInstance = self::$odoo->find(static::model(), $id, static::fieldNames());
        if (null === $odooInstance) {
            return null;
        }
        return static::hydrate($odooInstance);
    }

    /**
     * @param array $ids
     * @return array
     */
    public static function read(array $ids)
    {
        return array_map(function($item) {
            return static::hydrate($item);
        }, self::$odoo->read(static::model(), $ids, static::fieldNames()));
    }

    /**
     * @return string
     * @throws ConfigurationException
     * @throws \ReflectionException
     */
    protected static function model()
    {
        $reflectionClass = new \ReflectionClass(static::class);
        $reader = new AnnotationReader();
        $model = $reader->getClassAnnotation($reflectionClass, Model::class);
        
        if (null === $model) {
            throw new ConfigurationException("Missing Model Attribute");
        }

        return $model->name;
    }

    public static function query()
    {
        //TODO: Lazy evaluate fields only for queries that needs fields :low
        return new Odoo\Models\ModelQuery(static::newInstance(), self::$odoo->model(static::model())->fields(static::fieldNames()));
    }

    public static function all()
    {
        return static::query()->get();
    }

    public int $id;

    public function exists()
    {
        return isset($this->id);
    }

    /**
     * @return $this
     */
    public function save(): static
    {
        if ($this->exists()) {
            $updateResponse = self::$odoo->write(static::model(), [$this->id], (array)static::dehydrate($this));
            if (false === $updateResponse) {
                throw new OdooModelException("Failed to update model");
            }
        } else {
            $createResponse = self::$odoo->create(static::model(), (array)static::dehydrate($this));
            if (false === $createResponse) {
                throw new OdooModelException("Failed to create model");
            }
            $this->id = $createResponse;
        }

        return $this;
    }

    public function fill(iterable $properties)
    {
        $reflectionClass = new \ReflectionClass(static::class);

        foreach ($properties as $name => $value) {
            if($reflectionClass->hasProperty($name)){
                $this->{$name} = $value;
            }else {
                throw new UndefinedPropertyException("Property $name not defined");
            }
        }

        return $this;
    }


    public function equals(OdooModel $model)
    {
        $reflectionClass = new \ReflectionClass(static::class);
        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            if($property->isInitialized($this)){
                if(!$property->isInitialized($model)){
                    return false;
                }
                if($this->{$property->name} !== $model->{$property->name}){
                    return false;
                }
            }else{
                if($property->isInitialized($model)){
                    return false;
                }
            }

        }
        return true;
    }

}