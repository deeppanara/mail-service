<?php

namespace App\Controller\Web;

use App\Entity\EmailLog;
use App\Form\EmailLogType;
use App\Repository\EmailLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/email/log")
 */
class EmailLogController extends AbstractController
{
    /**
     * @Route("/", name="email_log_index", methods={"GET"})
     */
    public function index(EmailLogRepository $emailLogRepository): Response
    {
        return $this->render('email_log/index.html.twig', [
            'email_logs' => $emailLogRepository->findBy([], ['expected_sent_time' => 'DESC'], 50),
        ]);
    }

    /**
     * @Route("/{id}", name="email_log_show", methods={"GET"})
     */
    public function show(EmailLog $emailLog): Response
    {
        return $this->render('email_log/show.html.twig', [
            'email_log' => $emailLog,
        ]);
    }

    /**
     * @Route("/{id}", name="email_log_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EmailLog $emailLog): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emailLog->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emailLog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('email_log_index');
    }
}
