<?php declare(strict_types=1);

namespace Swoft\View\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Context\Context;
use Swoft\Http\Server\Contract\MiddlewareInterface;
use Swoft\Http\Server\Middleware\AcceptMiddleware;
use Swoft\Stdlib\Arrayable;
use Swoft\View\ViewRegister;

/**
 * The middleware of view
 *
 * @Bean()
 */
class ViewMiddleware implements MiddlewareInterface
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Throwable
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        $response = $this->responseView($request, $response);

        return $response;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface                         $request
     * @param \Psr\Http\Message\ResponseInterface|\Swoft\Http\Message\Response $response
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Throwable
     */
    private function responseView(ServerRequestInterface $request, ResponseInterface $response)
    {
        $ctx   = Context::mustGet();
        $views = ViewRegister::getViews();

        // the info of view model
        $controllerClass  = $ctx->get('controllerClass');
        $controllerAction = $ctx->get('controllerAction');

        $actionId = $controllerClass . '@' . $controllerAction;
        if (!isset($views[$actionId])) {
            return $response;
        }

        // Get layout and template
        [$layout, $template] = $views[$actionId];

        // accept and the of response
        $accepts       = $request->getHeader('accept');
        $currentAccept = \current($accepts);

        /* @var \Swoft\Http\Message\Response $response */
        $responseAttribute = AttributeEnum::RESPONSE_ATTRIBUTE;

        $data = $response->getAttribute($responseAttribute);

        // the condition of view
        $isTextHtml = !empty($currentAccept) && $response->isMatchAccept($currentAccept, 'text/html');
        $isTemplate = $controllerClass && $response->isArrayable($data) && $template;

        // show view
        if ($isTextHtml && $isTemplate) {
            if ($data instanceof Arrayable) {
                $data = $data->toArray();
            }

            /* @var \Swoft\View\Renderer $view */
            $view     = \Swoft::getBean('view');
            $content  = $view->render($template, $data, $layout);
            $response = $response
                ->withContent($content)
                ->withAttribute($responseAttribute, null)
                ->withoutHeader('Content-Type')->withAddedHeader('Content-Type', 'text/html');
        }

        return $response;
    }
}
