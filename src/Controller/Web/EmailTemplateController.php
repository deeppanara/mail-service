<?php

namespace App\Controller\Web;

use App\Entity\EmailTemplate;
use App\Form\EmailTemplateType;
use App\Manager\MailManager;
use App\Repository\EmailTemplateRepository;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/email/template")
 */
class EmailTemplateController extends AbstractController
{
    /**
     * @Route("/", name="email_template_index", methods={"GET"})
     */
    public function index(EmailTemplateRepository $emailTemplateRepository, MailManager $mailManager): Response
    {
        return $this->render('email_template/index.html.twig', [
            'email_templates' => $emailTemplateRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="email_template_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $emailTemplate = new EmailTemplate();
        $form = $this->createForm(EmailTemplateType::class, $emailTemplate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emailTemplate);
            $entityManager->flush();

            return $this->redirectToRoute('email_template_index');
        }

        return $this->render('email_template/new.html.twig', [
            'email_template' => $emailTemplate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="email_template_show", methods={"GET"})
     */
    public function show(EmailTemplate $emailTemplate): Response
    {
        return $this->render('email_template/show.html.twig', [
            'email_template' => $emailTemplate,
        ]);
    }

    /**
     * @Route("/{id}/preview", name="email_template_show_preview", methods={"GET"})
     */
    public function preview(EmailTemplate $emailTemplate): Response
    {
        return new Response($emailTemplate->getBodyHtml());
    }
    /**
     * @Route("/{id}/edit", name="email_template_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EmailTemplate $emailTemplate): Response
    {
        $form = $this->createForm(EmailTemplateType::class, $emailTemplate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('email_template_index');
        }

        return $this->render('email_template/edit.html.twig', [
            'email_template' => $emailTemplate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="email_template_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EmailTemplate $emailTemplate): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emailTemplate->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emailTemplate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('email_template_index');
    }
}
