<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\FakerStoreApi\FakerStoreApiInterface;
use Illuminate\Console\Command;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle(FakerStoreApiInterface $fakerApi)
    {
        $id = $this->option('id');
        try {
            if ($id) {
                $this->info("Iniciando a importação do produto: $id");
                $product = $fakerApi->getById($id);
                $this->importProducts([$product]);
            } else {
                $this->info('Iniciando a importação dos produtos');
                $products = $fakerApi->all();
                $this->importProducts($products);
            }
            $this->info('importação finalizada');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    private function importProducts(array $products)
    {
        $bar = $this->output->createProgressBar(count($products));
        $bar->start();
        foreach ($products as $product) {
            Product::firstOrCreate(
                [
                    'name'          => $product['title']
                ],
                [
                    'description'   => $product['description'],
                    'category'      => $product['category'],
                    'price'         => $product['price'],
                    'image_url'     => $product['image'],
                ]
            );

            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }
}
