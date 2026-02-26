<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\TmdbApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/movies', name: 'movie_')]
class MovieController extends AbstractController
{
    public function __construct(
        private TmdbApiService $tmdbApiService,
    ) {
    }

    #[Route('/top-rated', name: 'top_rated_list')]
    public function topRated(Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $data = $this->tmdbApiService->getTopRatedMovies($page);

        return $this->render('movie/top_rated.html.twig', [
            'movies' => $data['results'],
            'current_page' => $data['page'],
            'total_pages' => $data['total_pages'],
            'total_results' => $data['total_results'],
        ]);
    }
}
