<?php namespace AubinLrx\LaravelRepositories;

use AubinLrx\LaravelRepositories\Contracts\RepositoryInterface;
use AubinLrx\LaravelRepositories\Exceptions\RepositoryException;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class Repository implements RepositoryInterface {

    /**
     * @var App
     */
    public $app;

    /**
     * The model use in the repository
     * @var Model
     */
    protected $model;

    /**
     * Specify the model class
     * @return mixed
     */
    abstract function model();

    /**
     * The class constructor
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Return all records
     * 
     * @param  array  $columns
     * @return mixed
     */
    public function all($columns = array('*'))
    {
        return $this->model->get($columns);
    }

    /**
     * Paginate the model
     * 
     * @param  integer $perPage 
     * @param  array   $columns 
     * @return mixed 
     */
    public function paginate($perPage = 15, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * Create a new record
     * 
     * @param  array  $data
     * @return mixed
     */
    public function create(array $attributes = [])
    {
        return $this->model->create($attributes);
    }

    /**
     * Update an existing record
     * 
     * @param  $id
     * @param  array  $data
     * @param  string $attribute
     * @return mixed
     */
    public function update($id, array $data)
    {
        $model = $this->model->find($id);

        return $model->update($data);
    }

    /**
     * Destroy an existing record
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * Find a record
     * 
     * @param $id
     * @param  array  $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Find or fail
     *
     * @param $id
     * @param array $columns 
     * @return mixed
     */
    public function findOrFail($id, $columns = array('*'))
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * Find a record by criteria
     * 
     * @param  $field
     * @param  $value
     * @param  array  $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'))
    {
        return $this->model->where($field, '=', $value)->first($columns);
    }

    /**
     * Instanciate the model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \RepositoryException
     */
    public function makeModel() 
    {
        $model = $this->app->make($this->model());

        if(!$model instanceof Model)
        {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\Database\Elloquent\Model");
        }

        return $this->model = $model;

    }

}