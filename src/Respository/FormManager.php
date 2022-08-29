<?php


namespace App\Respository;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use \Dotenv;

/**
 * FormManager using SwiftMailer for ContactForm
 */
class FormManager
{
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

        $email = (new Email())
            ->from(getenv('MAILER_USER'))
            ->to($email)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Confirmation de votre inscription ' . $username)
            ->text('Votre inscription a bien été prise en compte')
            ->html('
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <title>Confirmation de votre inscription</title>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                        <style type="text/css">
                            * {
                                -ms-text-size-adjust:100%;
                                -webkit-text-size-adjust:none;
                                -webkit-text-resize:100%;
                                text-resize:100%;
                            }
                            a{
                                outline:none;
                                color:#40aceb;
                                text-decoration:underline;
                            }
                            a:hover{text-decoration:none !important;}
                            .nav a:hover{text-decoration:underline !important;}
                            .title a:hover{text-decoration:underline !important;}
                            .title-2 a:hover{text-decoration:underline !important;}
                            .btn:hover{opacity:0.8;}
                            .btn a:hover{text-decoration:none !important;}
                            .btn{
                                -webkit-transition:all 0.3s ease;
                                -moz-transition:all 0.3s ease;
                                -ms-transition:all 0.3s ease;
                                transition:all 0.3s ease;
                            }
                            table td {border-collapse: collapse !important;}
                            .ExternalClass, .ExternalClass a, .ExternalClass span, .ExternalClass b, .ExternalClass br, .ExternalClass p, .ExternalClass div{line-height:inherit;}
                            @media only screen and (max-width:500px) {
                                table[class="flexible"]{width:100% !important;}
                                table[class="center"]{
                                    float:none !important;
                                    margin:0 auto !important;
                                }
                                *[class="hide"]{
                                    display:none !important;
                                    width:0 !important;
                                    height:0 !important;
                                    padding:0 !important;
                                    font-size:0 !important;
                                    line-height:0 !important;
                                }
                                td[class="img-flex"] img{
                                    width:100% !important;
                                    height:auto !important;
                                }
                                td[class="aligncenter"]{text-align:center !important;}
                                th[class="flex"]{
                                    display:block !important;
                                    width:100% !important;
                                }
                                td[class="wrapper"]{padding:0 !important;}
                                td[class="holder"]{padding:30px 15px 20px !important;}
                                td[class="nav"]{
                                    padding:20px 0 0 !important;
                                    text-align:center !important;
                                }
                                td[class="h-auto"]{height:auto !important;}
                                td[class="description"]{padding:30px 20px !important;}
                                td[class="i-120"] img{
                                    width:120px !important;
                                    height:auto !important;
                                }
                                td[class="footer"]{padding:5px 20px 20px !important;}
                                td[class="footer"] td[class="aligncenter"]{
                                    line-height:25px !important;
                                    padding:20px 0 0 !important;
                                }
                                tr[class="table-holder"]{
                                    display:table !important;
                                    width:100% !important;
                                }
                                th[class="thead"]{display:table-header-group !important; width:100% !important;}
                                th[class="tfoot"]{display:table-footer-group !important; width:100% !important;}
                            }
                        </style>
                    </head>
                    <body style="margin:0; padding:0;" bgcolor="#eaeced">
                        <table style="min-width:320px;" width="100%" cellspacing="0" cellpadding="0" bgcolor="#eaeced">
                            <!-- fix for gmail -->
                            <tr>
                                <td class="hide">
                                    <table width="600" cellpadding="0" cellspacing="0" style="width:600px !important;">
                                        <tr>
                                            <td style="min-width:600px; font-size:0; line-height:0;">&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="wrapper" style="padding:0 10px;">
                                    <!-- module 1 -->
                                    <table data-module="module-1" data-thumb="thumbnails/01.png" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td data-bgcolor="bg-module" bgcolor="#eaeced">
                                                <table class="flexible" width="600" align="center" style="margin:0 auto;" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="padding:29px 0 30px;">
                                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <th class="flex" width="113" align="left" style="padding:0;">
                                                                        <table class="center" cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td style="line-height:0;">
                                                                                    <a target="_blank" style="text-decoration:none;" href="https://www.bastienmoreau.com/"><img src="https://zupimages.net/up/22/34/qqgu.png" border="0" style="font:bold 12px/12px Arial, Helvetica, sans-serif; color:#606060;" align="left" vspace="0" hspace="0" width="33" height="40" alt="Bastien Moreau logo" /></a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </th>
                                                                    <th class="flex" align="left" style="padding:0;">
                                                                        <table width="100%" cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td data-color="text" data-size="size navigation" data-min="10" data-max="22" data-link-style="text-decoration:none; color:#888;" class="nav" align="right" style="font:bold 13px/15px Arial, Helvetica, sans-serif; color:#888;">
                                                                                    <a target="_blank" style="text-decoration:none; color:#888;" href="https://www.bastienmoreau.com/">Acceuil</a> &nbsp; &nbsp; <a target="_blank" style="text-decoration:none; color:#888;" href="https://www.bastienmoreau.com/posts">Projets</a> &nbsp; &nbsp; <a target="_blank" style="text-decoration:none; color:#888;" href="https://www.bastienmoreau.com/contact">Contact</a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </th>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- module 2 -->
                                    <table data-module="module-2" data-thumb="thumbnails/02.png" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td data-bgcolor="bg-module" bgcolor="#eaeced">
                                                <table class="flexible" width="600" align="center" style="margin:0 auto;" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td class="img-flex"><img src="https://images.unsplash.com/photo-1518135714426-c18f5ffb6f4d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1496&q=80" style="vertical-align:top;" width="600" height="306" alt="" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td data-bgcolor="bg-block" class="holder" style="padding:58px 60px 52px;" bgcolor="#f9f9f9">
                                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td data-color="title" data-size="size title" data-min="25" data-max="45" data-link-color="link title color" data-link-style="text-decoration:none; color:#292c34;" class="title" align="center" style="font:35px/38px Arial, Helvetica, sans-serif; color:#292c34; padding:0 0 24px;">
                                                                        Merci de votre inscription
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td data-color="text" data-size="size text" data-min="10" data-max="26" data-link-color="link text color" data-link-style="font-weight:bold; text-decoration:underline; color:#40aceb;" align="center" style="font:bold 16px/25px Arial, Helvetica, sans-serif; color:#888; padding:0 0 23px;">
                                                                        <p>Salut '.$username.'!<br>
                                                                        Merci de ton attention et de ton inscription.<br>
                                                                        J&#039éspère que tu trouvera les informations dont tu as besoin, et si tu as des question, je suis la.<br>
                                                                        À bientôt.</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:0 0 20px;">
                                                                        <table width="134" align="center" style="margin:0 auto;" cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td data-bgcolor="bg-button" data-size="size button" data-min="10" data-max="16" class="btn" align="center" style="font:12px/14px Arial, Helvetica, sans-serif; color:#f8f9fb; text-transform:uppercase; mso-padding-alt:12px 10px 10px; border-radius:2px;" bgcolor="#7bb84f">
                                                                                    <a target="_blank" style="text-decoration:none; color:#f8f9fb; display:block; padding:12px 10px 10px;" href="https://www.bastienmoreau.com/">Voir plus</a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr><td height="28"></td></tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table data-module="module-3" data-thumb="thumbnails/03.png" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td data-bgcolor="bg-module" bgcolor="#eaeced">
                                                <table class="flexible" width="600" align="center" style="margin:0 auto;" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td class="footer" style="padding:0 0 10px;">
                                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                                <tr class="table-holder">
                                                                    <th class="tfoot" width="400" align="left" style="vertical-align:top; padding:0;">
                                                                        <table width="100%" cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td data-color="text" data-link-color="link text color" data-link-style="text-decoration:underline; color:#797c82;" class="aligncenter" style="font:12px/16px Arial, Helvetica, sans-serif; color:#797c82; padding:0 0 10px;">
                                                                                    Bastien Moreau, 2021 &nbsp; Tois droits reservés.
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </th>
                                                                    <th class="thead" width="200" align="left" style="vertical-align:top; padding:0;">
                                                                        <table class="center" align="right" cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td class="btn" valign="top" style="line-height:0; padding:3px 0 0;">
                                                                                    <a target="_blank" style="text-decoration:none;" href="https://github.com/duffman033"><img src="https://img.icons8.com/ios-glyphs/344/github.png" border="0" style="font:12px/15px Arial, Helvetica, sans-serif; color:#797c82;" align="left" vspace="0" hspace="0" width="25" height="25" alt="g+" /></a>
                                                                                </td>
                                                                                <td width="20"></td>
                                                                                <td class="btn" valign="top" style="line-height:0; padding:3px 0 0;">
                                                                                    <a target="_blank" style="text-decoration:none;" href="https://www.linkedin.com/in/m-bastien"><img src="https://img.icons8.com/glyph-neue/2x/linkedin-circled.png" border="0" style="font:12px/15px Arial, Helvetica, sans-serif; color:#797c82;" align="left" vspace="0" hspace="0" width="25" height="25" alt="in" /></a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </th>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!-- fix for gmail -->
                            <tr>
                                <td style="line-height:0;"><div style="display:none; white-space:nowrap; font:15px/1px courier;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div></td>
                            </tr>
                        </table>
                    </body>
                </html>
            ');

        $mailer->send($email);
    }
}
