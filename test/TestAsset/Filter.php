<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-latte for the canonical source repository
 * @copyright Copyright (c) 2017 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-latte/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace ZendTest\Expressive\Latte\TestAsset;

class Filter
{
    public static function ext1($s, $p = null)
    {
        return 'ext1' . $s . $p;
    }

    public static function ext2($s, $p = 1, $r = 2)
    {
        return 'ext2' . $s . '|' . $p . '|' . $r . '|';
    }
}
