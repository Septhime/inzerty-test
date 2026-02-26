<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TmdbApiService
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $tmdbApiKey,
        private string $tmdbBaseUrl,
    ) {
    }

    /**
     * Retrieves the top-rated movies from TMDB API.
     *
     * @param int $page Page number for pagination (default: 1)
     *
     * @return array{
     *     page: int,
     *     results: list<array{
     *         id: int,
     *         title: string,
     *         overview: string,
     *         poster_path: ?string,
     *         vote_average: float,
     *         vote_count: int,
     *         release_date: string,
     *     }>,
     *     total_pages: int,
     *     total_results: int
     * }
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getTopRatedMovies(int $page = 1): array
    {
        if (null == $this->tmdbApiKey) {
            throw new \RuntimeException('TMDB API key is not set. Please set the TMDB_API_KEY environment variable.');
        }
        $response = $this->httpClient->request('GET', $this->tmdbBaseUrl.'/movie/top_rated', [
            'auth_bearer' => $this->tmdbApiKey,
            'query' => [
                'page' => $page,
                'language' => 'fr-FR',
            ],
        ]);

        /** @var array{page: int, results: list<array{id: int, title: string, overview: string, poster_path: ?string, vote_average: float, vote_count: int, release_date: string}>, total_pages: int, total_results: int} $data */
        $data = $response->toArray();

        return $data;
    }

    /**
     * Retrieves the top-rated TV shows from TMDB API.
     *
     * @param int $page Page number for pagination (default: 1)
     *
     * @return array{
     *     page: int,
     *     results: list<array{
     *         id: int,
     *         name: string,
     *         overview: string,
     *         poster_path: ?string,
     *         vote_average: float,
     *         vote_count: int,
     *         first_air_date: string,
     *     }>,
     *     total_pages: int,
     *     total_results: int
     * }
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getTopRatedTvShows(int $page = 1): array
    {
        if (null == $this->tmdbApiKey) {
            throw new \RuntimeException('TMDB API key is not set. Please set the TMDB_API_KEY environment variable.');
        }
        $response = $this->httpClient->request('GET', $this->tmdbBaseUrl.'/tv/top_rated', [
            'auth_bearer' => $this->tmdbApiKey,
            'query' => [
                'page' => $page,
                'language' => 'fr-FR',
            ],
        ]);

        /** @var array{page: int, results: list<array{id: int, name: string, overview: string, poster_path: ?string, vote_average: float, vote_count: int, first_air_date: string}>, total_pages: int, total_results: int} $data */
        $data = $response->toArray();

        return $data;
    }
}
