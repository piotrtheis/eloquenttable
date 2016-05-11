<?php

namespace Tysdever\EloquentTable;

use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Pagination\Presenter as PresenterContract;
use Illuminate\Pagination\BootstrapThreeNextPreviousButtonRendererTrait;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Pagination\UrlWindowPresenterTrait;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\HtmlString;

class BootstrapThreeLimitPresenter implements PresenterContract
{
    use BootstrapThreeNextPreviousButtonRendererTrait, UrlWindowPresenterTrait;

    /**
     * The paginator implementation.
     *
     * @var \Illuminate\Contracts\Pagination\Paginator
     */
    protected $paginator;

    /**
     * The URL window data structure.
     *
     * @var array
     */
    protected $window;

    /**
     * Avalilable limit range.
     *
     * @var array
     */
    protected $limitRange;

    /**
     * Create a new Bootstrap presenter instance.
     *
     * @param  \Illuminate\Contracts\Pagination\Paginator  $paginator
     * @param  \Illuminate\Pagination\UrlWindow|null  $window
     * @return void
     */
    public function __construct(PaginatorContract $paginator, $limitRange = null, UrlWindow $window = null)
    {

        $this->paginator = $paginator;

        $this->paginator->addQuery('limit', Input::get('limit'));

        $this->window = is_null($window) ? UrlWindow::make($paginator) : $window->get();

        $this->limitRange = $limitRange ?: [10, 25, 50, 100];
    }

    /**
     * Determine if the underlying paginator being presented has pages to show.
     *
     * @return bool
     */
    public function hasPages()
    {
        return $this->paginator->hasPages();
    }

    /**
     * Convert the URL window into Bootstrap HTML.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function render()
    {
        $html = '';

        if ($this->hasPages()) {
            $html .= new HtmlString(sprintf(
                '<div class="pull-right"><ul class="pagination">%s %s %s</ul></div>',
                $this->getPreviousButton(),
                $this->getLinks(),
                $this->getNextButton()
            ));
        }

        if ((bool) $this->paginator->total()) {
            $html .= new HtmlString(sprintf(
                '<div class="pull-left"><div class="dropdown">%s %s</div></div>',
                $this->getActiveLimitWrapper(),
                $this->getLimitLinks()
            ));
        }

        return $html . '<div class="clearfix"></div>';
    }

    /**
     * Get the current limit from the paginator.
     *
     * @return int
     */
    public function currentLimit()
    {
        return (int) $this->paginator->perPage();
    }

    /**
     * Get HTML wrapper for current limit.
     *
     * @param  string  $limit
     * @return string
     */
    public function getActiveLimitWrapper()
    {
        return '<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">' . $this->currentLimit() . ' <span class="caret"></span></button>';
    }

    /**
     * Get HTML wrapper for others limit links.
     *
     * @return string
     */
    public function getLimitLinks()
    {
        $range = array_diff($this->limitRange, [$this->currentLimit()]);

        $html = '';

        foreach ($range as $limit) {
            $html .= $this->getLimitLinkWrapper($limit);
        }

        return new HtmlString(sprintf('<ul class="dropdown-menu">%s</ul>', $html));

    }

    /**
     * Get HTML wrapper for limit link.
     *
     * @param  string  $limit
     * @return string
     */
    protected function getLimitLinkWrapper($limit)
    {
        return '<li><a href="' . $this->paginator->addQuery('limit', $limit)->url($this->currentPage()) . '">' . $limit . '</a></li>';
    }

    /**
     * Get HTML wrapper for an available page link.
     *
     * @param  string  $url
     * @param  int  $page
     * @param  string|null  $rel
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $rel = is_null($rel) ? '' : ' rel="' . $rel . '"';

        return '<li><a href="' . htmlentities($url) . '"' . $rel . '>' . $page . '</a></li>';
    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return '<li class="disabled"><span>' . $text . '</span></li>';
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<li class="active"><span>' . $text . '</span></li>';
    }

    /**
     * Get a pagination "dot" element.
     *
     * @return string
     */
    protected function getDots()
    {
        return $this->getDisabledTextWrapper('...');
    }

    /**
     * Get the current page from the paginator.
     *
     * @return int
     */
    protected function currentPage()
    {
        return $this->paginator->currentPage();
    }

    /**
     * Get the last page from the paginator.
     *
     * @return int
     */
    protected function lastPage()
    {
        return $this->paginator->lastPage();
    }
}
