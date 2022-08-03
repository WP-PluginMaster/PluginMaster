<?php

namespace PluginMaster\Bootstrap\System;

use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\SideMenu\SideMenuInterface;

class SideMenu implements SideMenuInterface
{
    /**
     * @var array
     */
    public array $data ;

    /**
     * @var string
     */
    public string $prentSlug ;


    /**
     * @var SideMenu|null
     */
    private static ?self $instance = null;


    /**
     * @return SideMenu
     */
    private static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = App::get(SideMenu::class);
        }

        return self::$instance;
    }

    /**
     * @param string $title
     * @param string|null $slug
     * @return SideMenu
     */
    public static function parent(string $title, string $slug = null): self
    {
        $slug = $slug ?? str_replace(' ', '-', strtolower($title));

        static::getInstance()->prentSlug  = $slug;

        static::getInstance()->data[] = [
          'title' => $title,
          'menu_title' => $title,
          'slug' =>   $slug,
      ];

        return  static::getInstance();
    }

    private function getCurrentIndex(): int
    {
        return count($this->data) - 1;
    }

    public function capability(string $capability = 'manage_options'): self
    {
        $this->data[$this->getCurrentIndex()]['capability'] = $capability;

        return $this;
    }

    public function menuTitle(string $title): self
    {
        $this->data[$this->getCurrentIndex()]['menu_title'] = $title;

        return $this;
    }

    public function callback($callback): self
    {
        $this->data[$this->getCurrentIndex()]['callback'] = $callback;

        return $this;
    }

    public function icon(string $icon): self
    {
        $this->data[$this->getCurrentIndex()]['icon'] = $icon;

        return $this;
    }

    public function position(int $position): self
    {
        $this->data[$this->getCurrentIndex()]['position'] = $position;

        return $this;
    }

    /**
     * $option['as'] required
     * @param string $title
     * @param string|null $slug
     * @return SideMenu
     */
    public function child(string $title, string $slug = null): self
    {
        if(!$this->prentSlug){
            return $this;
        }

        $this->data[] = [
            'title' => $title,
            'menu_title' => $title,
            'submenu' => true,
            'parent_slug' =>  $this->prentSlug,
            'slug' =>   $slug ?? str_replace(' ', '_', strtolower($title)),
        ];

        return $this;
    }

    /**
     * $option['as'] required
     * @param string $parentSlug
     * @param string $title
     * @param string|null $slug
     * @return SideMenu
     */
    public static function submenu(string $parentSlug, string $title, string $slug = null): self
    {
        static::getInstance()->data[] = [
            'title' => $title,
            'menu_title' => $title,
            'submenu' => true,
            'parent_slug' =>  $parentSlug,
            'slug' =>   $slug ?? str_replace(' ', '_', strtolower($title)),
        ];

        return static::getInstance();
    }

    public function getData(): array
    {
        return $this->data;
    }

}
