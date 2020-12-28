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
 * This is an Laravel Console Menu implementation.
 */
class Menu extends CliMenuBuilder
{
    /**
     * The current option value.
     *
     * @var mixed
     */
    private $result;
    private $subitems;

    /**
     * Menu constructor.
     *
     * @param string $title
     * @param array $options
     */
    public function __construct($title = '', array $options = [])
    {
        parent::__construct();

        $this->addLineBreak(' ')
            ->setTitleSeparator('-');

        $this->setMarginAuto();

        $this->setTitle($title);

        $this->addOptions($options);
    }

    /**
     * Adds a new option.
     *
     * @param mixed $value
     * @param string $label
     *
     * @return \AshrafSaeed\ConsoleMenu\Menu
     */
    public function addOption($value, string $label): Menu
    {
        $this->addMenuItem(
            new MenuOption(
                $value,
                $label,
                function (CliMenu $menu) {
                    $this->result = $menu->getSelectedItem()->getValue();
                    $menu->close();
                }
            )
        );

        return $this;
    }

    /**
     * Adds multiple options.
     *
     * @param array $options
     *
     * @return \AshrafSaeed\ConsoleMenu\Menu
     */
    public function addOptions(array $options): Menu
    {
        foreach ($options as $value => $label) {
            $this->addOption($value, $label);
        }

        return $this;
    }

    /**
     * Add a question.
     *
     * @param string $label
     * @param string $placeholder
     *
     * @return \AshrafSaeed\ConsoleMenu\Menu
     */
    public function addQuestion(string $label, string $placeholder = ''): Menu
    {
        $itemCallable = function (CliMenu $menu) use ($label, $placeholder) {
            $result = $menu->askText()
                ->setPromptText($label)
                ->setPlaceholderText($placeholder)
                ->ask();

            $this->result = $result->fetch();

            $menu->close();
        };

        $this->addItem($label, $itemCallable);

        return $this;
    }


    /**
     * Add a Submenu.
     *
     * @param string $label
     * @param string $sublabel
     * @param array $options
     *
     * @return \AshrafSaeed\ConsoleMenu\Menu
     */

    public function subMenu(string $label, string $sublable, array $options): menu
    {
        $itemCallable = function (CliMenu $menu) use ($label) {

            static $selectItem = [];
            $item = $menu->getSelectedItem()->getText(); 

            if (($key = array_search($item, $selectItem)) !== false) {
                unset($selectItem[$key]);
            }
            if($menu->getSelectedItem()->getChecked()) {           
               $selectItem[] = $item;
            }
            $this->subitems = $selectItem;
        };

        $proccesCallable = function (CliMenu $menu) use($label) {

            $this->result = [$label, $this->subitems];
            $menu->close();

        };

        $this->addSubMenu($label, function (CliMenuBuilder $submenu) use ($label, $sublable, $options, $itemCallable, $proccesCallable) {
            $submenu->setTitle($label.' > '.$sublable);

            foreach ($options as $item) {
                $submenu->addCheckboxItem($item, $itemCallable);
            }
            $submenu->addLineBreak('-')
            ->addItem('Procced', $proccesCallable)
            ->addLineBreak('-');

        });

        return $this;
    }

    /**
     * Open the menu and return the result.
     *
     * @return mixed
     */
    public function open()
    {
        $this->build()
            ->open();

        return $this->result;
    }

    /**
     * Set the result.
     *
     * @param mixed $result
     *
     * @return \AshrafSaeed\ConsoleMenu\Menu
     */
    public function setResult($result): Menu
    {
        $this->result = $result;

        return $this;
    }
}