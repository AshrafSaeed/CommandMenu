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

namespace AshrafSaeed\CommandMenu;

use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use PhpSchool\CliMenu\CliMenu;

/**
 * This is a Laravel Console Menu Option implementation.
 */
class SubMenuOption extends CliMenuBuilder
{
    /**
     * The option value.
     *
     * @var mixed
     */
    private $value;

    /**
     * Creates a new menu option.
     *
     * @param int|string $value
     * @param string $text
     * @param callable $callback
     * @param bool $showItemExtra
     * @param bool $disabled
     */
    public function __construct(string $label, string $sublable, array $options, callable $callback)
    {
        parent::__construct();

        $this->setTitle($label.' > '.$sublable);
        $this->addCheckboxItems($options, $callback);
    }

    public function addCheckboxItems(array $options, callable $callback) {

        foreach ($options as $item) {
            $this->addCheckboxItem($item, $callback);
        }

    }

    
}