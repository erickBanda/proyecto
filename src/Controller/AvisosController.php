<?php

namespace App\Controller;

use App\Entity\Avisos;
use App\Form\AvisosType;
use App\Repository\AvisosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/avisos')]
class AvisosController extends AbstractController
{
    #[Route('/', name: 'app_avisos_index', methods: ['GET'])]
    public function index(AvisosRepository $avisosRepository): Response
    {
        return $this->render('avisos/index.html.twig', [
            'avisos' => $avisosRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_avisos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $aviso = new Avisos();
        $form = $this->createForm(AvisosType::class, $aviso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aviso);
            $entityManager->flush();

            return $this->redirectToRoute('app_avisos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('avisos/new.html.twig', [
            'aviso' => $aviso,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avisos_show', methods: ['GET'])]
    public function show(Avisos $aviso): Response
    {
        return $this->render('avisos/show.html.twig', [
            'aviso' => $aviso,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_avisos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avisos $aviso, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AvisosType::class, $aviso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_avisos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('avisos/edit.html.twig', [
            'aviso' => $aviso,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avisos_delete', methods: ['POST'])]
    public function delete(Request $request, Avisos $aviso, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aviso->getId(), $request->request->get('_token'))) {
            $entityManager->remove($aviso);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_avisos_index', [], Response::HTTP_SEE_OTHER);
    }
}
