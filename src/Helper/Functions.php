<?php declare(strict_types=1);

if (!function_exists('view')) {
    /**
     * @param string            $template
     * @param array             $data
     * @param string|null|false $layout
     *
     * @return \Swoft\Http\Message\Response
     * @throws Throwable
     */
    function view(string $template, array $data = [], $layout = null)
    {
        /**
         * @var \Swoft\View\Renderer         $renderer
         * @var \Swoft\Http\Message\Response $response
         */
        $renderer = \Swoft::getSingleton('view');
        $response = \Swoft\Context\Context::mustGet()->getResponse();
        $content  = $renderer->render(\Swoft::getAlias($template), $data, $layout);

        return $response
            ->withContent($content)
            ->withHeader('Content-Type', 'text/html');
    }
}
