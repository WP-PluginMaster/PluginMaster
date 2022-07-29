<?php

namespace PluginMaster\Bootstrap\System;


use PluginMaster\Bootstrap\System\Helpers\App;
use PluginMaster\Contracts\Enqueue\EnqueueInterface;
use PluginMaster\Foundation\Enqueue\EnqueueHandler;

class Enqueue implements EnqueueInterface
{
    /**
     * @var string
     */
    protected static string $hook;

    /**
     * @var Enqueue|null
     */
    private static ?self $instance = null;

    /**
     * @var array
     */
    protected array $data;

    /**
     * @return Enqueue|null
     */
    private static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = App::get(Enqueue::class) ;
        }

        return self::$instance;
    }

    /**
     * @return Enqueue
     */
    public static function front(): self
    {
        static::$hook = 'wp_enqueue_scripts';
        return self::getInstance();
    }

    /**
     * @return Enqueue
     */
    public static function admin(): self
    {
        static::$hook = 'admin_enqueue_scripts';
        return static::getInstance();
    }

    public static function on($hook): self
    {
        static::$hook = $hook;
        return static::getInstance();
    }

    /**
     * @param string $path
     * @param string|null $id
     * @return Enqueue
     */
    public function script(string $path, ?string $id = null): self
    {
        $this->data[] = [
            'id' => $id,
            'path' => $path,
            'script' => true,
            'hook' => static::$hook,
        ];

        return $this;
    }

    /**
     * @param array $deps
     * @return Enqueue
     */
    public function dependency(array $deps): self
    {
        $this->data[$this->getCurrentIndex()]['dependency'] = $deps;

        return $this;
    }

    private function getCurrentIndex(): int
    {
        return count($this->data) -1;
    }

    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return Enqueue
     */
    public function inHeader(): self
    {
        $this->data[$this->getCurrentIndex()]['in_footer'] = false;

        return $this;
    }

    /**
     * @return Enqueue
     */
    public function inFooter(): self
    {
        $this->data[$this->getCurrentIndex()]['in_footer'] = true;

        return $this;
    }

    /**
     * @param string $ver
     * @return Enqueue
     */
    public function version(string $ver): self
    {
        $this->data[$this->getCurrentIndex()]['version'] = $ver;

        return $this;
    }

    /**
     * @param array $attributes
     * @return Enqueue
     */
    public function attributes(array $attributes): self
    {
        $this->data[$this->getCurrentIndex()]['attributes'] = $attributes;

        return $this;
    }

    /**
     * @param string $cdnPath
     * @param string|null $id
     * @return Enqueue
     */
    public function scriptCdn(string $cdnPath, ?string $id = null): self
    {
        $this->data[]  = [
            'id' => $id,
            'path' => $cdnPath,
            'cdn' => true,
            'script' => true,
            'hook' => static::$hook,
        ];

        return $this;
    }

    /**
     * @param string $path
     * @param string|null $id
     * @param string $media
     * @return Enqueue
     */
    public function style(string $path, ?string $id = null, string $media = 'all'): self
    {
        $this->data[] = [
            'id' => $id,
            'path' => $path,
            'media' => $media,
            'hook' => static::$hook,
        ];

        return $this;
    }

    /**
     * @param string $cdnPath
     * @param string|null $id
     * @param string $media
     * @return Enqueue
     */
    public function styleCdn(string $cdnPath, ?string $id = null, string $media = 'all'): self
    {
        $this->data[] = [
            'id' => $id,
            'path' => $cdnPath,
            'media' => $media,
            'cdn' => true,
            'hook' => static::$hook,
        ];

        return $this;
    }

    /**
     * @param string $handle
     * @param string $objectName
     * @param $data
     */
    public function localizeScript(string $handle, string $objectName, $data): void
    {
        $this->data[]  = [
            'param' => [$handle, $objectName, $data],
            'type' => 'localizeScript',
            'hook' => static::$hook,
        ];
    }

    /**
     * @param string $data
     * @param array $option
     */
    public function inlineScript(string $data, array $option = []): void
    {
        $this->data[]  = [
            'param' => [$data, $option],
            'type' => 'inlineScript',
            'hook' => static::$hook,
        ];
    }

    /**
     * @param string $data
     * @param string $handle
     */
    public function inlineStyle(string $data, string $handle = ''): void
    {
        $this->data[]  = [
            'param' => [$data, $handle],
            'type' => 'inlineStyle',
            'hook' => static::$hook,
        ];
    }

}


