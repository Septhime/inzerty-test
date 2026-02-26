# CinemaDB

Application web permettant de consulter les films et séries TV les mieux notés, alimentée par l'API TMDB (The Movie Database).

## Pages

| Route                 | Description                               |
|-----------------------|-------------------------------------------|
| `/`                   | Accueil avec liens vers les classements   |
| `/movies/top-rated`   | Classement des films les mieux notes      |
| `/tv-shows/top-rated` | Classement des series TV les mieux notees |

## Prerequis

- [Docker](https://docs.docker.com/get-docker/) et [Docker Compose](https://docs.docker.com/compose/install/)
- Une cle API TMDB (gratuite sur [themoviedb.org](https://www.themoviedb.org/settings/api))

## Configuration

Copiez le fichier `.env` en `.env.local` et renseignez votre cle API TMDB :

```bash
cp .env .env.local
```

Editez `.env.local` :

```dotenv
TMDB_API_KEY=votre_cle_api_tmdb
```

## Lancement

### Developpement

```bash
docker compose up --build --wait
```

L'application est accessible sur [https://localhost:80](https://localhost:80).

Il permet d'accéder à la version debug de Symfony avec la toolbar.

### Production

```bash
docker compose -f compose.yaml -f compose.prod.yaml up --build --wait
```

N'affiche pas la toolbar et essaye d'être le plus performant possible pour une mise en production

## Structure du projet

```
src/
  Controller/
    HomeController.php          # Page d'accueil
    MovieController.php         # Classement films
    TvShowController.php        # Classement series TV
  Service/
    TmdbApiService.php          # Client API TMDB
templates/
  base.html.twig                # Layout principal (navbar, fond anime)
  home/index.html.twig          # Page d'accueil
  movie/top_rated.html.twig     # Liste des films
  tv_show/top_rated.html.twig   # Liste des series
assets/
  app.js                        # Point d'entree JS
  styles/app.css                # Tailwind CSS + animations
```
