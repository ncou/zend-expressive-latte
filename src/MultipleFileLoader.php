<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-latte for the canonical source repository
 * @copyright Copyright (c) 2017 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-latte/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Zend\Expressive\Latte;

use Latte\Loaders\FileLoader;
use Zend\Expressive\Latte\Exception\NamespaceUsedException;
use Zend\Expressive\Latte\Exception\UnknownNamespaceException;

class MultipleFileLoader implements MultiplePathLoaderInterface
{
    /**
     * @var string
     */
    protected $fileExtension;

    /**
     * @var FileLoader[]
     */
    protected $loaders = [];

    /**
     * @var string[]
     */
    protected $paths = [];

    public function __construct(string $fileExtension = 'latte')
    {
        $this->fileExtension = $fileExtension;
    }

    public function addPath(string $path, string $namespace = null) : void
    {
        if (isset($this->loaders[$namespace])) {
            throw new NamespaceUsedException(sprintf('Namespace %s is already being used', $namespace));
        }

        $this->loaders[$namespace] = new FileLoader($path);
        $this->paths[$namespace] = $path;
    }

    public function getPaths() : array
    {
        return $this->paths;
    }

    /**
     * @param string $name
     * @return [string $namespace, string $file]
     * @throws UnknownNamespaceException
     */
    private function getName(string $name) : array
    {
        if (strpos($name, '::')) {
            [$namespace, $file] = explode('::', $name, 2);
        } else {
            $namespace = null;
            $file = $name;
        }

        if (! isset($this->loaders[$namespace])) {
            throw new UnknownNamespaceException(sprintf('Namespace %s is not defined', $namespace));
        }

        return [$namespace, $file . '.' . $this->fileExtension];
    }

    /**
     * Returns template source code.
     *
     * @param string $name
     * @return string
     */
    public function getContent($name)
    {
        [$namespace, $file] = $this->getName($name);

        return $this->loaders[$namespace]->getContent($file);
    }

    /**
     * Checks whether template is expired.
     *
     * @return bool
     */
    public function isExpired($name, $time)
    {
        [$namespace, $file] = $this->getName($name);

        return $this->loaders[$namespace]->isExpired($file, $time);
    }

    /**
     * Returns referred template name.
     *
     * @return string
     */
    public function getReferredName($name, $referringName)
    {
        return $name;
    }

    /**
     * Returns unique identifier for caching.
     *
     * @return string
     */
    public function getUniqueId($name)
    {
        [$namespace, $file] = $this->getName($name);

        return $this->loaders[$namespace]->getUniqueId($file);
    }
}
