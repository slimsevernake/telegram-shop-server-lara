<?php


namespace App\Services;


use App\Services\Interfaces\ApiServiceInterface;
use Google\Service\Sheets;

class GoogleSheetsApiService implements ApiServiceInterface
{
    private Sheets $api;
    private $id;
    private $range;

    public function __construct(?string $id = null, ?string $range = null)
    {
        $this->id = $id ?? config('api.google_sheets.id');
        $this->range = $range ?? config('api.google_sheets.range');
        $this->setupClient();
    }

    public function parse(string $id): array
    {
        $response = $this->api->spreadsheets_values->get($id, $this->range);
        $data = array_slice($response['values'], 1);
        return $data;
    }

    private function setupClient()
    {
        $client = new \Google_Client(config('api.google.config'));
        $this->api = new Sheets($client);
    }
}
