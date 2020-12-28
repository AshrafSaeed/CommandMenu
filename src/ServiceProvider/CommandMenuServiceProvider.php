<?php

declare(strict_types=1);

/**
 * This file is part of Console Menu.
 *
 * (c) Muhammad Ashraf <avanix.sol@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace AshrafSaeed\CommandMenu\ServiceProvider;

use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use AshrafSaeed\CommandMenu\Menu;
use AshrafSaeed\CommandMenu\Console\MigrationCommand;

/**
 * This is an Laravel Console Menu Service Provider implementation.
 */
class CommandMenuServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        
        /*
         * Returns a menu builder.
         *
         * @param  string $title
         * @param  array $options
         *
         * @return \AshrafSaeed\ConsoleMenu\Menu
        */
        
        Command::macro(
            'menu',
            function (string $title = '', array $options = []) {
                return new Menu($title, $options);
            }
        );


        /*
         * @return \AshrafSaeed\ConsoleMenu\Menu
         *
         * Register the command if we are using the application via the CLI
        */

        if ($this->app->runningInConsole()) {
            $this->commands([
                MigrationCommand::class,
            ]);
        }

    }
}