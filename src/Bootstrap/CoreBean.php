<?php

namespace Swoft\View\Bootstrap;

use Swoft\Bean\Annotation\BootBean;
use Swoft\Core\BootBeanIntereface;
use Swoft\View\Base\View;

/**
 *  The core bean of view
 *
 * @BootBean()
 */
class CoreBean implements BootBeanIntereface
{
    public function beans()
    {
        return [
            'view'         => [
                'class'     => View::class,
            ],
        ];
    }
}