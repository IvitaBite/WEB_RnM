<?php

declare(strict_types=1);

namespace App;

use App\Models\Character;
use App\Models\CharacterCollection;
use App\Models\Episode;
use App\Models\EpisodeCollection;
use App\Models\Season;
use App\Models\SeasonCollection;
use GuzzleHttp\Client;
use Carbon\Carbon;

class Api
{
    private Client $client;
    private const API_URL = 'https://rickandmortyapi.com/api/episode';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetchEpisodes(): EpisodeCollection
    {
        $episodes = new EpisodeCollection();

        $page = 1;

        while (true) {
            $response = $this->client->get(self::API_URL . "?page=$page");

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['results'])) {
                foreach ($data['results'] as $result) {
                    $episode = new Episode(
                        $result['id'],
                        $result['name'],
                        Carbon::parse($result['air_date']),
                        $result['episode']
                    );
                    $episodes->add($episode);
                }
            }
            if (!isset($data['info']['next'])) {
                break;
            }
            $page++;
        }
        //var_dump($episodes);
        return $episodes;
    }

    public function fetchEpisode(int $id): Episode
    {
        $responseEpisode = $this->client->get(self::API_URL . "/{$id}");

        $dataEpisode = json_decode($responseEpisode->getBody()->getContents(), true);

        $episode = new Episode(
            $dataEpisode['id'],
            $dataEpisode['name'],
            Carbon::parse($dataEpisode["air_date"]),
            $dataEpisode['episode']
        );

        $characterCollection = new CharacterCollection();

        foreach ($dataEpisode['characters'] as $character) {
            $responseCharacter = $this->client->get($character);
            $dataCharacter = json_decode($responseCharacter->getBody()->getContents(), true);
            $character = new Character(
                $dataCharacter['name'],
                $dataCharacter['species'],
                $dataCharacter['gender'],
                $dataCharacter['origin']['name'],
                $dataCharacter['image'],
                $dataCharacter['status']
            );
            $characterCollection->add($character);
        }
        $episode->setCharacters($characterCollection);

        return $episode;
    }

    public function fetchSeasons(): SeasonCollection
    {
        $seasonCollection = new SeasonCollection();
        $addedSeasonIds = [];

        foreach ($this->fetchEpisodes()->getEpisodes() as $episode) {
            /** @var Episode $episode */
            $episodeSeason = (int)substr($episode->getEpisode(), 1, 2);
            $seasonName = "Season $episodeSeason";

            if (!in_array($episodeSeason, $addedSeasonIds)) {
                $seasonCollection->add(new Season($episodeSeason, $seasonName));
                $addedSeasonIds[] = $episodeSeason;
            }
        }

        return $seasonCollection;
    }

    public function fetchEpisodesBySeasonId(int $seasonId): array
    {
        $episodes = [];

        foreach ($this->fetchEpisodes()->getEpisodes() as $episode) {
            /** @var Episode $episode */
            $episodeSeason = (int)substr($episode->getEpisode(), 1, 2);

            if ($episodeSeason === $seasonId) {
                $episodes[] = [
                    'id' => $episode->getId(),
                    'name' => $episode->getName(),
                    'air_date' => $episode->getAirDate(),
                    'episode' => $episode->getEpisode(),
                ];
            }
        }
        return $episodes;
    }

    public function searchEpisodes(string $query): array
    {
        $episodes = $this->fetchEpisodes()->getEpisodes();

        $matchingEpisodes = [];

        foreach ($episodes as $episode) {
            /** @var Episode $episode */
            if ($episode->matchesSearchQuery($query)) {
                $matchingEpisodes[] = [
                    'id' => $episode->getId(),
                    'name' => $episode->getName(),
                    'episode' => $episode->getEpisode(),
                ];
            }
        }

        return $matchingEpisodes;
    }
}
