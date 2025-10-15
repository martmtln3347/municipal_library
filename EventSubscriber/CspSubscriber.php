<?php
// src/EventSubscriber/CspSubscriber.php
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CspSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::RESPONSE => 'onResponse'];
    }

    public function onResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $policy = "default-src 'self'; script-src 'self' https://trusted.cdn.com";
        $response->headers->set('Content-Security-Policy', $policy);
        // Pour tester sans bloquer au début :
        // $response->headers->set('Content-Security-Policy-Report-Only', $policy);
    }
}
