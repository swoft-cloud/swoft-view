<?php

namespace Swoft\View\Bootstrap;

use Swoft\Bean\Annotation\BootBean;
use Swoft\Blade\Bean\Annotation\Blade;
use Swoft\Core\BootBeanInterface;
use Swoft\View\Base\BladeView;

/**
 *  The core bean of view
 *
 * @BootBean()
 */
class CoreBean implements BootBeanInterface
{

    /**
     * @return array
     */
    public function beans():array
    {


        return [
            'view'         => [
                'class'     => BladeView::class,
            ],
        ];
    }
}