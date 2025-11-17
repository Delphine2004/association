<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Entity\Event;
use App\Form\EventType;
use App\Form\EventSearchType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/event')]
final class EventController extends AbstractController
{

    public function __construct(private string $uploadsEventsDirectory) {}

    #[Route(name: 'app_event_index', methods: ['GET'])]
    public function index(
        Request $request,
        EventRepository $eventRepository
    ): Response {

        // Création du formulaire
        $form = $this->createForm(EventSearchType::class);
        $form->handleRequest($request);

        // Données du formulaire
        $criteria = $form->getData();

        $events = $eventRepository->findEventsByFields($criteria);

        // Recrée un formulaire vide, sans données préremplies
        $form = $this->createForm(EventSearchType::class);

        return $this->render('event/index.html.twig', [
            'searchForm' => $form->createView(),
            'events' => $events,
        ]);
    }

    #[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //  Récupérer le fichier uploadé (UploadedFile ou null)
            $uploadedFile = $form->get('picture')->getData();

            if ($uploadedFile) {

                //  Générer un nom unique (ex: 654a51b8d1e21.jpg)
                $fileName = uniqid() . '.' . $uploadedFile->guessExtension();

                //  Déplacer le fichier dans ton dossier uploads
                $uploadedFile->move($this->uploadsEventsDirectory, $fileName);

                //  Stocker le nom du fichier dans l'entité
                $event->setPicture($fileName);
            }

            $event->setCreatedBy($this->getUser());

            $entityManager->persist($event);
            $entityManager->flush();

            $this->addFlash('success', 'Evénement créé avec succès.');
            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_event_show', methods: ['GET'])]
    public function show(
        Event $event
    ): Response {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Event $event,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $event->setUpdatedBy($this->getUser());

            $entityManager->flush();

            return $this->redirectToRoute('app_event_show', ['id' => $event->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Event $event,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
    }
}
