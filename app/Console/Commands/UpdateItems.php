<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use App\Item;

class UpdateItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Torn items';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client(['base_uri' => env('TORN_API_URL')]);

        $response = $client->request('GET', 'torn', [
            'query' => [
                'selections' => 'items',
                'key' => env('TORN_KEY')
            ]
        ]);

        $result = $response->getBody();
        $items = json_decode($result, true);

        foreach ($items['items'] as $id => $item) {
            Item::updateOrCreate(
                ['id' => $id],
                $item
            );
        }

        return 'ok';
    }
}
