<?php

namespace Tysdever\EloquentTable\Contracts;

interface SearcherPresenter
{

    /**
     * Render presenter form, forcing to use self object.
     *
     * @param \Tysdever\EloquentTable\Contracts\SearcherPresenter $presenter
     * @return [type] [description]
     */
    public function render(SearcherPresenter $presenter);

    /**
     * Get the field which define the search criteria.
     *
     * @return string
     */
    public function getSearchedField();

    /**
     * Get the field query as search value.
     *
     * @return mixed
     */
    public function getSearchedQUery();
}
