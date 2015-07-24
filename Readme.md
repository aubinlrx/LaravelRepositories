# LaravelRepositories
Repository Pattern for Laravel 5 with Eloquent ORM

**Version**: 0.1.5

## Filterable Trait

Handy method to filter query

**Usages**

```php
<?php

use AubinLrx\LaravelRepositories\Repository;
use AubinLrx\LaravelRepositories\Traits\FilterableTrait;

class BookRepository extends Repository {

   use FilterableTrait;
   
   /**
    * The fields that are filterable
    * @var array
    */
   protected $filterable = ['author_id', 'date_range'];

   public function getAllWithFilter() {
      return $this->applyFilterToQuery( $this->model->query() )->all(); 
   }

   public function filterByDateRange($query, $value) {
        return $query->whereBetween('date', $value);
   }

   public function filterBy($field, $value) {
        $this->addFilter($field, $value);
        return $this;
   }

}

class BookController extends Controller {

    public function __construct(BookRepository $books) 
    {
        $this->books = $books;
    }

    public function index(Request $request) 
    {
        $books = $this->books->filterBy('date_range', $request->only(['str_date', 'end_date']))
           ->filterBy('author_id', $request->only('author_id'))
           ->getAllWithFilter();

        return view('books.index', compact('books'));
    }

}

?>
```

## Release Logs

**v0.1.5**
- bug fix: Laravel 5.1 create method
- feature: Add findOrFail method