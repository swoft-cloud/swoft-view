<?php
/**
 * Created by PhpStorm.
 * User: Colin
 * Date: 2018/6/5
 * Time: 12:55
 */

namespace Swoft\View\Base;

use Swoft\View\Factory;
use Swoft\View\Compilers\BladeCompiler;
use Swoft\View\Engines\CompilerEngine;
use Swoft\View\Engines\EngineResolver;
use Swoft\View\Filesystem;
use Swoft\View\FileViewFinder;

class BladeView extends AbstractViewInterface
{

    /**
     * @param string      $view
     * @param array       $data
     * @param string|null $layout
     * @return string
     */
    public function render(string $view, array $data = [], $layout = null)
    {

        $viewsPath = [\Swoft\App::getAlias('@resources') . '/views/'];  // blade文件目录
        $compiled  = \Swoft\App::getAlias('@runtime') . '/views/';      // 编译后文件目录

        $file     = new Filesystem;
        $compiler = new BladeCompiler($file, $compiled);
        $resolver = new EngineResolver;
        // 使用blade模板
        $resolver->register('blade', function () use ($compiler) {
            return new CompilerEngine($compiler);
        });
        $factory = new Factory($resolver, new FileViewFinder($file, $viewsPath));
        $factory->addExtension('tpl', 'blade');
        $content = $factory->make($view, $data)->render();
        return $content;
    }
}