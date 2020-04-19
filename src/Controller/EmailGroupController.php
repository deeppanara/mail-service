<?php

namespace App\Controller;

use App\Entity\EmailGroup;
use App\Form\EmailGroupType;
use App\Repository\EmailTemplateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/email/group")
 */
class EmailGroupController extends AbstractController
{
    /**
     * @Route("/", name="email_group_index", methods={"GET"})
     */
    public function index(EmailTemplateRepository $emailTemplateRepository): Response
    {
        return $this->render('email_group/index.html.twig', [
            'email_groups' => $emailTemplateRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="email_group_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $emailGroup = new EmailGroup();
        $form = $this->createForm(EmailGroupType::class, $emailGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emailGroup);
            $entityManager->flush();

            return $this->redirectToRoute('email_group_index');
        }

        return $this->render('email_group/new.html.twig', [
            'email_group' => $emailGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="email_group_show", methods={"GET"})
     */
    public function show(EmailGroup $emailGroup): Response
    {
        return $this->render('email_group/show.html.twig', [
            'email_group' => $emailGroup,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="email_group_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EmailGroup $emailGroup): Response
    {
        $form = $this->createForm(EmailGroupType::class, $emailGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('email_group_index');
        }

        return $this->render('email_group/edit.html.twig', [
            'email_group' => $emailGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="email_group_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EmailGroup $emailGroup): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emailGroup->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emailGroup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('email_group_index');
    }
}
