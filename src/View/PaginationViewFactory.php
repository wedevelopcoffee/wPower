<?php
namespace WeDevelopCoffee\wPower\View;

/**
 * ViewFactory for Pagination.
 */
class PaginationViewFactory {
    protected $views;
    protected $paginator;
    protected $elements;

    /**
     * Create view
     * @return string
     */
    public function make($view, $params)
    {
        $this->view = $view;
        $this->paginator = $params['paginator'];
        $this->elements = $params['elements'];
        return $this;
    }

    public function render()
    {
        // @todo replace this with a view instance.
        wView('pagination', ['paginator' => $this->paginator, 'elements' => $this->elements]);
    }
}
