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

    public function render($view, $params = [])
    {
        $loader = new FilesystemLoader('../template');
        $twig = new Environment(
            $loader,
            [
            'cache' => false, // __DIR__ . /tmp',
            'debug' => true,]
        );

        $twig->addGlobal('_server', $_SERVER);
        $twig->addGlobal('_post', $_POST);
        $twig->addGlobal('_get', $_GET);
        $twig->addExtension(new DebugExtension());
        $twig->addGlobal('session', $_SESSION);


        try {
            echo $twig->render($view, $params);
        } catch (LoaderError $e) {
        } catch (RuntimeError $e) {
        } catch (SyntaxError $e) {
        }
    }
}
