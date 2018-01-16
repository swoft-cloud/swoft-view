<?php

namespace Swoft\View\Bean\Wrapper;

use Swoft\View\Bean\Annotation\View;
use Swoft\Bean\Wrapper\AbstractWrapperInterface;

/**
 * 路由注解封装器
 *
 * @uses      ControllerWrapper
 * @version   2017年09月04日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class ControllerWrapper extends AbstractWrapperInterface
{
    /**
     * 类注解
     *
     * @var array
     */
    protected $classAnnotations
        = [
        ];

    /**
     * 属性注解
     *
     * @var array
     */
    protected $propertyAnnotations
        = [
        ];

    /**
     * 方法注解
     *
     * @var array
     */
    protected $methodAnnotations
        = [
            View::class,
        ];

    /**
     * 是否解析类注解
     *
     * @param array $annotations
     *
     * @return bool
     */
    public function isParseClassAnnotations(array $annotations)
    {
        return false;
    }

    /**
     * 是否解析属性注解
     *
     * @param array $annotations
     *
     * @return bool
     */
    public function isParsePropertyAnnotations(array $annotations)
    {
        return false;
    }

    /**
     * 是否解析方法注解
     *
     * @param array $annotations
     *
     * @return bool
     */
    public function isParseMethodAnnotations(array $annotations)
    {
        return isset($annotations[View::class]);
    }
}
