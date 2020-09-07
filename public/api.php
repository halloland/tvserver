<?php
use App\App;
use Doctrine\ORM\AbstractQuery;


require $_SERVER["DOCUMENT_ROOT"] . "/config/bootstrap.php";

const ACTION_SEARCH_NAME = "search_name";

$app = new App();

$moviesRepository = $entityManager->getRepository('App\Entities\Movie');
$genresRepository = $entityManager->getRepository('App\Entities\Genre');

$queryBuilder = $moviesRepository->createQueryBuilder("m");
$requestApiParams = [
    "name" => null,
    "genre_id" => null,
    "premier_year_start" => null,
    "premier_year_end" => null,
    "sort_by" => null,
    "sort_type" => null,
    "page" => null,
    "per_page" => null,
    "action" => null,
];

$fetchedApiRequest = $requestApiParams;

array_walk(
    $fetchedApiRequest,
    function (&$value, $key) use ($app) {
        $trimmedValue = trim($app->getRequest()->query->get($key));
        $value = !empty($trimmedValue) ? $trimmedValue : null;
    }
);

if ($fetchedApiRequest["name"]) {
    $queryBuilder->nameLike($fetchedApiRequest["name"]);
}

if ($fetchedApiRequest["genre_id"]) {
    $queryBuilder->genreId(intval($fetchedApiRequest["genre_id"]));
}

if ($fetchedApiRequest['premier_year_start']) {
    $queryBuilder->setPremierYearStart(new DateTime($fetchedApiRequest['premier_year_start']));
}

if ($fetchedApiRequest['premier_year_end']) {
    $queryBuilder->setPremierYearEnd(new DateTime($fetchedApiRequest['premier_year_end']));
}

if ($fetchedApiRequest["sort_by"]) {
    $queryBuilder->sort($fetchedApiRequest["sort_by"], $fetchedApiRequest["sort_type"]);
}

if ($fetchedApiRequest["name"] && $fetchedApiRequest["action"] === ACTION_SEARCH_NAME) {
    $queryBuilder->select("m.title");
    $queryBuilder->setMaxResults(5);
    $titles = $queryBuilder->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);

    echo json_encode(
        array_map(
            function ($item) {
                return $item["title"];
            },
            $titles
        )
    );

    exit();
}

$total = (clone $queryBuilder)->select("count(m.id)")
    ->getQuery()
    ->getSingleScalarResult();



if ($fetchedApiRequest["page"]) {
    $queryBuilder->paginate($fetchedApiRequest["page"], $fetchedApiRequest["per_page"]);
}

$movies = $queryBuilder->getQuery()->getResult();

$genres = $genresRepository->createQueryBuilder("g")
    ->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);

$moviesResult = [];

$moviesResult["movies"] = array_map(
    function ($movie) {
        $movieArray = [
            "id" => $movie->getId(),
            "external_id" => $movie->getExternalId(),
            "title" => $movie->getTitle(),
            "popularity" => $movie->getPopularity(),
            "release_date" => $movie->getReleaseDate()->format('Y-m-d'),
            "vote_count" => $movie->getVoteCount(),
            "vote_average" => $movie->getVoteAverage(),
        ];

        $movieArray["genres"] = array_map(
            function ($genre) {
                return [
                    "id" => $genre->getId(),
                    "external_id" => $genre->getExternalId(),
                    "name" => $genre->getName(),
                ];
            },
            $movie->getGenres()->toArray()
        );

        return $movieArray;
    },
    $movies
);

$moviesResult["total"] = intval($total);
$moviesResult["genres"] = $genres;

echo json_encode($moviesResult);
