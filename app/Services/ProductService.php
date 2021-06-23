<?php


namespace App\Services;

use App\Models\Product;
use App\Services\Interfaces\ApiServiceInterface;

class ProductService
{
    private $parse_api = GoogleSheetsApiService::class;
    private $parse_id;

    public function __construct()
    {
        $this->parse_id = config('api.google_sheets.products_id');
    }

    public function parse(string $id = null)
    {
        $api = new $this->parse_api;
        $data = $api->parse($id ?? $this->parse_id);
        $array_products = $this->convertParsedData($data);
        Product::insert($array_products);
    }

    private function convertParsedData(array $data): array
    {
        $now = (string) now();
        return array_map(function ($item) use ($now) {
            return [
                'name' => $item[1],
                'quantity' => $item[2],
                'description' => $item[3],
                'price' => $item[4],
                'image' => $item[5],
                'is_available' => $item[6],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $data);
    }
}
