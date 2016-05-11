<?php

namespace Tysdever\EloquentTable;

use Form;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Support\HtmlString;
use Request;
use Tysdever\EloquentTable\Contracts\SearcherPresenter as Presenter;

class SearcherPresenter implements Presenter
{

    /**
     * The paginator implementation.
     *
     * @var \Illuminate\Contracts\Pagination\Paginator
     */
    protected $paginator;

    /**
     * Collection object class.
     *
     * @var string
     */
    protected $model;

    /**
     * Table columns
     * @var array
     */
    protected $columns;

    /**
     * Create a new searcher instance.
     *
     * @param  \Illuminate\Contracts\Pagination\Paginator  $paginator
     * @return void
     */
    public function __construct(PaginatorContract $paginator)
    {

        $this->model = $paginator->getCollection()->getModel();

        $this->columns = $paginator->getCollection()->eloquentTableColumns;
    }

    /**
     * Convert the URL window into Bootstrap HTML.
     *
     * @param \Tysdever\EloquentTable\Contracts\SearcherPresenter $presenter
     * @return \Illuminate\Support\HtmlString
     */
    public function render(Presenter $presenter)
    {
        $url = \Request::url() . '?' . \Request::getQueryString();

        return new HtmlString(sprintf(
            '<form action="%s" class="form-inline pull-left"><div class="form-group">%s %s %s</div></form>',
            $url,
            $presenter->getColumnSelectList(),
            $presenter->getQueryField(),
            $presenter->getButton()
        ));
    }

    protected function getColumnSelectList()
    {
        $select = [];

        //set column labels
        foreach ($this->columns as $key => $value) {
            $select[$key] = $this->model->getFieldLabel($key);
        }

        return new HtmlString(sprintf(
            '<div class="input-group"><div class="input-group-addon"><i class="fa fa-list"></i></div>%s</div>',
            Form::select('search_column', $select, $this->getSearchedField(), ['class' => 'form-control input-sm'])
        ));
    }

    protected function getQueryField()
    {
        return Form::text('query', $this->getSearchedQUery(), ['class' => 'form-control input-sm', 'placeholder' => 'Search']);
    }

    protected function getButton()
    {
        return '<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>';
    }

    /**
     * Get the field which define the search criteria.
     *
     * @return string
     */
    public function getSearchedField()
    {
        return Request::input('search_column');
    }

    /**
     * Get the field query as search value.
     *
     * @return mixed
     */
    public function getSearchedQUery()
    {
        return Request::input('query');
    }
}
