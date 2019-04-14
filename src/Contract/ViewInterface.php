<?php

namespace Swoft\View\Contract;

/**
 * Class ViewInterface The interface of view
 * @since 1.0
 */
interface ViewInterface
{
    /**
     * @param string      $view
     * @param array       $data
     * @param string|null|false $layout Override default layout file
     *
     * @return string
     */
    public function render(string $view, array $data = [], $layout = null);
}
