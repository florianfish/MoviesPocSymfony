<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class HomeController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $response = $this->client->request('GET', 'https://api.themoviedb.org/3/trending/movie/day?language=fr-FR', [
          'headers' => [
            'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI0ZTg4NGI4NDJmNTJiYzkwYTg5MmQwY2MxY2E2YmY5OSIsIm5iZiI6MTY3ODYwNzgzMy42Nywic3ViIjoiNjQwZDg1ZDkzMjNlYmEwMTBiOTA4NzJmIiwic2NvcGVzIjpbImFwaV9yZWFkIl0sInZlcnNpb24iOjF9.LkYcIcrF3U8dof4X6mgN_Vmd6MhCvdhLuopnsEiFSBE',
            'accept' => 'application/json',
          ],
        ]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'popular_movies' => json_decode($response->getContent()),
        ]);
    }
}
