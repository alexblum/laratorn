<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Item;

class ItemViewController extends Controller
{
    public function index($itemId = 0)
    {
        try {
            $item = Item::findOrFail($itemId);
        } catch (ModelNotFoundException $e) {
            return [];
        }

        $client = new Client(['base_uri' => env('TORN_API_URL')]);

        $response = $client->request('GET', 'market/' . $item->id, [
            'query' => [
                'selections' => 'bazaar,itemmarket',
                'key' => env('TORN_KEY')
            ]
        ]);

        $body = $response->getBody();
        $itemMaket = json_decode($body, true);

        $result['market'] = $itemMaket;
        $result['info'] = $item;

        return $result;
    }
}
