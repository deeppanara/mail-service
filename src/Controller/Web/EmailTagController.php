<?php

namespace App\Controller\Web;

use App\Entity\EmailTag;
use App\Form\EmailTagType;
use App\Repository\EmailTagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/email/tag")
 */
class EmailTagController extends AbstractController
{
    /**
     * @Route("/", name="email_tag_index", methods={"GET"})
     */
    public function index(EmailTagRepository $emailTagRepository): Response
    {
        return $this->render('email_tag/index.html.twig', [
            'email_tags' => $emailTagRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="email_tag_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $emailTag = new EmailTag();
        $form = $this->createForm(EmailTagType::class, $emailTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emailTag);
            $entityManager->flush();

            return $this->redirectToRoute('email_tag_index');
        }

        return $this->render('email_tag/new.html.twig', [
            'email_tag' => $emailTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="email_tag_show", methods={"GET"})
     */
    public function show(EmailTag $emailTag): Response
    {
        return $this->render('email_tag/show.html.twig', [
            'email_tag' => $emailTag,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="email_tag_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EmailTag $emailTag): Response
    {
        $form = $this->createForm(EmailTagType::class, $emailTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('email_tag_index');
        }

        return $this->render('email_tag/edit.html.twig', [
            'email_tag' => $emailTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="email_tag_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EmailTag $emailTag): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emailTag->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emailTag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('email_tag_index');
    }
}
