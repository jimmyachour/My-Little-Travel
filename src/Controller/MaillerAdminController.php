<?php

namespace App\Controller;

use App\Entity\Mail;
use App\Form\MailType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin", name="admin_")
 */
class MaillerAdminController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     */
    public function index(Request $request, ObjectManager $manager,\Swift_Mailer $mailer): Response
    {
        $mail = new Mail();

        $form = $this->createForm(MailType::class, $mail);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $mail->addExp($this->getUser());
            $manager->persist($mail);
            $manager->flush();


            $message = (new \Swift_Message($mail->getSubject()))
                ->setFrom($this->getParameter('mailer_from'))
                ->setTo($mail->getRecipient())
                ->setBody($mail->getContent());

            $mailer->send($message);
        }
        return $this->render('Backend/MaillerAdmin/index.html.twig', ['formMail' => $form->createView()]);
    }
}