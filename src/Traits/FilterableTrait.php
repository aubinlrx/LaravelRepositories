<?php namespace AubinLrx\LaravelRepositories\Traits;

use AubinLrx\LaravelRepositories\Traits\Exceptions\FilterableException;

trait FilterableTrait {

    protected $filters = [];

    /**
     * Add criteria to the filters
     * 
     * @param string $field
     * @param mixed $value
     */
    protected function addFilter($field, $value) 
    {

        if ( ! property_exists($this, 'filterable'))
        {
            throw new FilterableException('Please set the $filterable property');
        }

        if( ! is_string($field))
        {
            throw new FilterableException('The first argument must be a string : ' + gettype($field) + ' given');
        }

        if (!in_array($field, $this->filterable)) {
            return false;
        }
              
        $this->filters[$field] = $value;

        return true;
    }

    /**
     * Apply the filter to a query
     * @param  QueryBuilder $query
     * @return QueryBuilder
     */
    protected function applyFiltersToQuery($query) 
    {
        foreach($this->filters as $field => $value) {

            $filterMethod = 'filterBy' . studly_case($field);

            if( method_exists($this, $filterMethod) ) {
                $this->$filterMethod($query, $value);
            } else {
                $query->where($field, $value);
            }
        }

        return $query;
    }

}