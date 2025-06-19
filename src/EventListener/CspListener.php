<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class CspListener
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        // Politique CSP mise à jour pour autoriser les ressources de cdn.jsdelivr.net
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; img-src 'self' data:;"
        );
    }
}

