<?php

namespace Tysdever\EloquentTable\Collection;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tysdever\EloquentTable\Traits\TableTrait;

/**
 * Class TableCollection.
 */
class TableCollection extends Collection
{
    use TableTrait;

    /**
     * Model object
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
