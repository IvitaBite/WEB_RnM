<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Api;
use App\Response;

class EpisodeController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function show(array $vars): Response
    {
        $id = (int)$vars['id'];

        return new Response('episode', [
            'episode' => $this->api->fetchEpisode($id),
        ]);
    }

    public function search(): Response
    {
        $input = $_GET['search'] ?? '';
        $results = $this->api->searchEpisodes($input);

        return new Response('search', [
            'episodes' => $results,
            'searchQuery' => $input,
        ]);
    }
}