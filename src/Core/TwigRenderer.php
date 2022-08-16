<?php


namespace App\Core;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;


class TwigRenderer
{
    private $twig;

    public function render($view, $params = [])
    {
        $loader = new FilesystemLoader('../template');
        $this->twig = new Environment(
            $loader, [
            'cache' => false, // __DIR__ . /tmp',
            'debug' => true,]
        );

        $this->twig->addGlobal('_server', $_SERVER);
        $this->twig->addGlobal('url',  $_SERVER['DOCUMENT_ROOT']);
        $this->twig->addGlobal('_post', $_POST);
        $this->twig->addGlobal('_get', $_GET);
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);


        try {
            echo $this->twig->render($view . '.twig', $params);
        } catch (LoaderError $e) {
        } catch (RuntimeError $e) {
        } catch (SyntaxError $e) {
        }
    }
}