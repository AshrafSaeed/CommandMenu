<?php

/**
 * This file is part of Console Menu.
 *
 * (c) Muhammad Ashraf <avanix.sol@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace AshrafSaeed\CommandMenu\Console;

use Illuminate\Console\Command;

class MigrationCommand extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:migrate';
    
    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'menu for run migration command';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $option = $this->menu('Migration')
        ->subMenu("migrate", "with", ['seed','force'])
        ->subMenu("migrate:fresh", "with", ['seed','force'])
        ->subMenu("migrate:refresh", "with", ['seed','force'])
        ->subMenu("migrate:reset", "with", ['seed','force'])
        ->addOption("migrate:rollback", "migrate:rollback")
        ->setForegroundColour('15')
        ->setBackgroundColour('6')
        ->addLineBreak('-')
        ->setBorder(1, 2, 1, 2, '42')
        ->open();

        dump($option);

        if(!empty($option)) {
            list($command, $attributes) = $this->transform($option);
            $this->call($command, $this->transform($attributes));
        
        } else {
            $this->info('no command selected');
        }
    }

    /**
     * @param array $option
     *
     * @return array
     */

    protected function transform($option)
    {

        dump($option);

        if(is_array($option)) {

            dd($option);

            $attributes = [];
            // $collection = collect($option);
            // if($collection->isNotEmpty()) {
            //     $attributes = $collection->mapWithKeys(function ($key, $value) {
            //             return ["--{$key}" => true];
            //         })->all();
            // }

            return [$option[0], $attributes];
        }

        return [$option, []];
    }
}