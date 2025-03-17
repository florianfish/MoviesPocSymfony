<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Cache\CacheInterface;

final class HomeController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
        private CacheInterface $cache,
        private ParameterBagInterface $parameterBag
    ) {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Vérifier si les films populaires sont déjà en cache
        $cachedMovies = $this->cache->get('trending_movies', function (CacheItem $item) {
            // Configurer la durée de vie du cache ici (par exemple, 1 heure)
            $item->expiresAfter($this->parameterBag->get('TMDB_EXPIRES_AFTER')); // 1 semaine

            // Faire l'appel à l'API TMDB
            $response = $this->client->request('GET', 'https://api.themoviedb.org/3/trending/movie/day?language=fr-FR', [
                'headers' => [
                  'Authorization' => 'Bearer ' . $this->parameterBag->get('tmdb_api'),
                  'accept' => 'application/json',
                ],
              ]);

            $data = json_decode($response->getContent());

            // Retourner les films populaires
            return $data->results;
        });

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'popular_movies' => $cachedMovies,
        ]);
    }
}
