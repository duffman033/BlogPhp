<?php


namespace App\Respository;

use App\Core\TwigRenderer;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use \Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * FormManager using SwiftMailer for ContactForm
 */
class FormManager
{
    protected TwigRenderer $renderer;

    public function __construct()
    {
        $this->renderer = new TwigRenderer();
    }

    /**
     * Manage Home Form
     *
     * @param $name
     * @param $forename
     * @param $email
     * @param $message
     * @throws TransportExceptionInterface
     */
    public function formTraitment($name, $forename, $email, $message)
    {
        $dotenv = Dotenv\Dotenv::createUnsafeImmutable(realpath(dirname(__FILE__) . '/../../'));
        $dotenv->load();

        $transport = Transport::fromDsn(getenv('MAILER_DSN'));
        $mailer = new Mailer($transport);

        $email = (new Email())
            ->from($email)
            ->to(getenv('MAILER_USER'))
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Message du Blog de ' . $name . ' ' .$forename)
            ->text($message);
//            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);
    }

    /**
     * Manage register form
     *
     * @param $email
     * @param $username
     * @throws TransportExceptionInterface
     */
    public function registerTraitment($email, $username)
    {
        $dotenv = Dotenv\Dotenv::createUnsafeImmutable(realpath(dirname(__FILE__) . '/../../'));
        $dotenv->load();

        $transport = Transport::fromDsn(getenv('MAILER_DSN'));
        $mailer = new Mailer($transport);

        $email = (new TemplatedEmail())
            ->from(getenv('MAILER_USER'))
            ->to($email)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Confirmation de votre inscription ' . $username)
//            ->text('Votre inscription a bien été prise en compte')
            ->htmlTemplate('User/registerMail.html.twig')
            ->context([
                'username' => $username,
            ]);
        $loader = new FilesystemLoader('../template');
        $twigEnv = new Environment($loader);
        $twigBodyRenderer = new BodyRenderer($twigEnv);
        $twigBodyRenderer->render($email);

        $mailer->send($email);
    }
}
