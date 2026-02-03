<?php

namespace App\Service;

use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\BSON\UTCDateTime;

class MongoNewsletterService
{
    private Collection $collection;

    public function __construct(Client $client, string $dbName, string $collectionName = 'newsletter')
    {
        $this->collection = $client->selectCollection($dbName, $collectionName);
    }

    public function addEmail(string $email, bool $agreement): bool
    {
        // Vérifier si l'email existe déjà
        $exists = $this->collection->findOne(['email' => $email]);
        if ($exists) {
            return false;
        }

        $result = $this->collection->insertOne([
            'email' => $email,
            'agreement' => $agreement,
            'createdAt' => new UTCDateTime(),
        ]);

        return $result->isAcknowledged();
    }

    public function getAllEmails(): array
    {
        $cursor = $this->collection->find();
        $emails = [];
        foreach ($cursor as $doc) {
            $emails[] = $doc['email'];
        }
        return $emails;
    }
}
