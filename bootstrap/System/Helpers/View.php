<?php


namespace PluginMaster\Bootstrap\System\Helpers;


class View
{

    /**
     * @param $path
     * @param array $data
     * @return string
     */
    public static function render($path, array $data = []): string
    {
        /** @var View $viewInstance */
        $viewInstance = App::get(View::class);

        return $viewInstance->resolvePHP($viewInstance->resolvePath($path), $data);
    }


    /**
     * @param $path
     * @return string
     */
    protected function resolvePath($path): string
    {
        $viewPath = '';

        foreach (explode('.', $path) as $path) {
            $viewPath .= '/' . $path;
        }

        return $viewPath;
    }

    /**
     * @param string $path
     * @param array $data
     * @return string
     */
    protected function resolvePHP(string $path, array $data = []): string
    {
        if (count($data)) {
            extract($data);
        }

        return include App::get()->viewPath() . $path . '.php';
    }
}
