<?php

namespace App\Controller\Api;

use App\Entity\Quote;
use App\Form\QuoteType;
use App\Repository\QuoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/v1/quote')]
class QuoteController extends AbstractController
{
    #[Route('/', name: 'app_quote_all', methods: ['GET'])]
    public function index(QuoteRepository $quoteRepository): Response
    {
        return $this->json($quoteRepository->findAll(), Response::HTTP_OK);
    }

    #[Route('/add', name: 'app_quote_add', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): Response
    {
        $quote = $serializer->deserialize($request->getContent(), Quote::class, 'json');
        $entityManager->persist($quote);
        $entityManager->flush();

        $location = $urlGenerator->generate('app_quote_single', ['id' => $quote->getId()]);

        return $this->json($quote, Response::HTTP_CREATED, ["Location" => $location]);
    }

    #[Route('/{id}', name: 'app_quote_single', methods: ['GET'])]
    public function show(Quote $quote): Response
    {
        return $this->json($quote, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_quote_update', methods: ['PUT'])]
    public function edit(Request $request, Quote $quote, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $updatedQuote = $serializer->deserialize($request->getContent(),
            Quote::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $quote]);


        $entityManager->persist($updatedQuote);
        $entityManager->flush();
        return $this->json(null, JsonResponse::HTTP_NO_CONTENT);
    }

    #[Route('/{id}', name: 'app_quote_delete', methods: ['DELETE'])]
    public function delete(Request $request, Quote $quote, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($quote);
        $entityManager->flush();

        return $this->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
