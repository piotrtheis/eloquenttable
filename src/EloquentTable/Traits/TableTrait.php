<?php

namespace Tysdever\EloquentTable\Traits;

use Closure;
use Form;
use Illuminate\Routing\Route as ActionRoute;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use Stevebauman\EloquentTable\EloquentTableServiceProvider;
use Stevebauman\EloquentTable\TableTrait as BaseTableTrait;
use Tysdever\EloquentTable\Collection\TableCollection;
use Tysdever\EloquentTable\Contracts\SearcherPresenter;
use Tysdever\Repository\Contracts\Criteria;
use Tysdever\EloquentTable\Builder;

trait TableTrait
{
    use BaseTableTrait, TableStreamerTrait;
    
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return Builder
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    /**
     * Stor row actions
     *
     * @var array
     */
    public $eloquentRowActions = array();

    /**
     * Stores the actions column modifications
     *
     * @var array
     */
    public $eloquentRowActionModifications = array();

    /**
     * Set row actions
     *
     * @param  array $actions
     * @return TableTrait
     */
    public function rowActions(array $actions)
    {

        $routeCollection = Route::getRoutes();

        foreach ($actions as $key => $action) {
            $route = $routeCollection->getByName($action);

            if (is_null($route)) {
                throw new Exception("No route for action");
            }

            $this->eloquentRowActions[$key] = $route;

        }

        return $this;
    }

    public function getActionButton(ActionRoute $route, $item)
    {

        $url = $this->resolveActionLink($route, $item);
        //$icon = Config::get('eloquenttable');

        if (in_array('GET', $route->methods())) {
            $html = new HtmlString(sprintf(
                '<a href="%s" class="btn btn-sm btn-success">%s</a>',
                $url,
                '<i class="fa fa-edit"></i>'
            ));
        } else {
            $html = Form::open(['url' => $url, 'method' => 'delete', 'class' => 'delete-confirm-action', 'id' => 'delete-confirm-action-' . $item->id]);
            $html .= Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-sm btn-danger', 'type' => 'submit']);
            $html .= Form::close();
        }

        return $html;
    }

    /**
     * Convert action route to link or form button.
     *
     * @param  Illuminate\Routing\Route  $route
     * @param  mixed $item
     * @return string  action link or form button
     */
    protected function resolveActionLink(ActionRoute $route, $item)
    {
        if (count($route->parameterNames()) > 1) {
            throw new Exception("Can't resolve action url");
        }

        $param = current($route->parameterNames());

        return URL::route($route->getName(), [$param => $item]);
    }

    /**
     * Stores modifications to rows.
     *
     * @param string  $action
     * @param Closure $closure
     *
     * @return $this
     */
    public function modifyAction($action, Closure $closure)
    {
        $this->eloquentRowActionModifications[$action] = $closure;

        return $this;
    }

    public function render($view = '')
    {

        // If no attributes have been set, we'll set them to the configuration defaults
        if (count($this->eloquentTableAttributes) === 0) {
            $attributes = Config::get('eloquenttable' . EloquentTableServiceProvider::$configSeparator . 'default_table_attributes', []);

            $this->attributes($attributes);
        }

        if (!$view) {
            $view = 'eloquenttable::table';
        }

        Session::put('eloquenttable_model', $this->getModel());

        return View::make($view, [
            'collection' => $this,
            'model'      => $this->getModel(),
        ])->render();
    }

    /**
     * Allows all columns on the current database table to be sorted through
     * query scope.
     *
     * @param $query
     * @param string $field
     * @param string $sort
     *
     * @return mixed
     */
    public function scopeSort($query, $field = null, $sort = null)
    {
        if ($field && $sort) {

            $columns = Schema::getColumnListing($this->table);

            if (in_array($field, $columns)) {

                if ($sort === 'asc' || $sort === 'desc') {

                    return $query->orderBy($field, $sort);
                }
            }
        }

        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Apply custom query criteria for search scope.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  \Tysdever\Repository\Contracts\Criteria $criteria
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeSearch($query, Criteria $criteria)
    {
        $query = $criteria->apply($query);

        return $query;
    }

    /**
     * Overrides the newCollection method from the model this extends from.
     *
     * @param array $models
     *
     * @return TableCollection
     */
    public function newCollection(array $models = array())
    {
        $collection = new TableCollection($models);
        $collection->setModel($this);

        return $collection;
    }

    public function searcher(SearcherPresenter $presenter)
    {
        return $presenter->render($presenter);
    }

    public function getSortable()
    {
        return $this->sortable;
    }
}
