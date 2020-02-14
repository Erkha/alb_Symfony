<?php

declare(strict_types=1);

namespace App\Service;

use App\Form\Contacter\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;

/**
 * permet de générer et traiter un formulaire de contact
 */
class Contacter
{
    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var MailerInterface */
    private $mailer;

    public function __construct(FormFactoryInterface $formFactory, MailerInterface $mailer)
    {
        $this->formFactory = $formFactory;
        $this->mailer = $mailer;
    }

    /**
     * @return string  the sluggified string
     */
    public function getContactForm(Request $request): FormInterface
    {
        $form =  $this->formFactory->createBuilder(
            ContactType::class,
            null,
            ['method' => Request::METHOD_POST]
        )
            ->getForm();
        $form->handleRequest($request);

        return $form;
    }

    private function sendMail(FormInterface $form): void
    {
        $data = $form->getData();
        $email = new TemplatedEmail();
        $email->from($_ENV['SERVER_MAIL'])
            ->to($_ENV['ADMIN_MAIL'])
            ->subject('nouveau contact AnimTheTime')
            ->htmlTemplate('templated_emails/contact.html.twig')
            ->context([
                'message'   => $data['message'],
                'name'      => $data['name'],
                'mail'     => $data['email'],
                'phone'     => $data['phone'],
            ]);
        $this->mailer->send($email);
    }

    public function isOk(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->sendMail($form);

            return true;
        }

        return false;
    }
}
