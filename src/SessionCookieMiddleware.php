<?php

declare(strict_types=1);

namespace GrotonSchool\Session;

use Dflydev\FigCookies\FigResponseCookies;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionCookieMiddleware implements MiddlewareInterface
{
    public function __construct(private Session $session) {}
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->session->middlewareStart($request);
        $response = $handler->handle($request);
        $this->session->save();
        return FigResponseCookies::set(
            $response,
            $this->session->getCookie()
        );
    }
}
