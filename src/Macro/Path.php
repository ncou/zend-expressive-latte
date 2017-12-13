<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-latte for the canonical source repository
 * @copyright Copyright (c) 2017 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-latte/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Zend\Expressive\Latte\Macro;

use Latte\IMacro;
use Latte\MacroNode;
use Latte\PhpWriter;
use Zend\Expressive\Latte\MacroInterface;

class Path implements MacroInterface
{
    public function begin(MacroNode $node, PhpWriter $writer) : string
    {
        return $writer->write('echo %modify(call_user_func($this->filters->urlHelper, %node.args))');
    }

    public function end(MacroNode $node, PhpWriter $writer) : ?string
    {
        return null;
    }

    public function attr(MacroNode $node, PhpWriter $writer) : ?string
    {
        return null;
    }

    public function flag() : ?int
    {
        return IMacro::AUTO_CLOSE;
    }
}
