<?php

declare(strict_types=1);

namespace Zend\Expressive\Latte\Macro;

use Latte\IMacro;
use Latte\MacroNode;
use Latte\PhpWriter;
use Zend\Expressive\Latte\MacroInterface;

class Url implements MacroInterface
{
    public function begin(MacroNode $node, PhpWriter $writer) : string
    {
        $path = 'call_user_func($this->filters->urlHelper, %node.args)';

        if (strpos(trim($node->args), '/') === 1) {
            $path = '%node.args';
        }

        return $writer->write(sprintf(
            'echo %%modify(call_user_func($this->filters->serverUrlHelper, %s))',
            $path
        ));
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
