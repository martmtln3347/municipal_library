<?php
// src/Controller/ThemeController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Routing\Attribute\Route;

class ThemeController
{
    #[Route('/theme/{mode}', name: 'app_theme', requirements: ['mode' => 'dark|light'])]
    public function set(string $mode): Response
    {
        $resp = new Response('OK');
        $value = $mode === 'dark' ? 'true' : 'false';
        $cookie = Cookie::create('myapp_dark_mode', $value, strtotime('+1 year'), '/', null, false, true, false, Cookie::SAMESITE_LAX);
        $resp->headers->setCookie($cookie);
        return $resp;
    }
}
