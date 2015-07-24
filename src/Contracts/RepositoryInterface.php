<?php namespace AubinLrx\LaravelRepositories\Contracts;

interface RepositoryInterface {

    public function all($columns = array('*'));

    public function paginate($perPage = 15, $columns = array('*'));

    public function create(array $data);

    public function update($id, array $data);

    public function destroy($id);

    public function find($id, $columns = array('*'));

    public function findOrFail($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));
}