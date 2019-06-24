<?php


namespace TrelloCycleTime\Client;


interface HttpClientInterface
{
    public function findAllCards(): array;

    public function findCreationCard(string $cardId): array;

    public function findAllCardHistory(string $cardId): array;

    public function createRequest(string $url);
}