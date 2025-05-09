<?php

declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ONGR\ElasticsearchDSL;

/**
 * A trait which handles the behavior of parameters in queries, filters, etc.
 */
trait ParametersTrait
{
    /**
     * @var array
     */
    private $parameters = [];

    /**
     * Checks if parameter exists.
     *
     * @param string $name
     *
     */
    public function hasParameter($name): bool
    {
        return isset($this->parameters[$name]);
    }

    /**
     * Removes parameter.
     *
     * @param string $name
     *
     * @return $this
     */
    public function removeParameter($name)
    {
        if ($this->hasParameter($name)) {
            unset($this->parameters[$name]);
        }

        return $this;
    }

    /**
     * Returns one parameter by it's name.
     *
     * @param string $name
     *
     * @return array|string|int|float|bool|\stdClass
     */
    public function getParameter($name)
    {
        return $this->parameters[$name];
    }

    /**
     * Returns an array of all parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param string                                $name
     * @param array|string|int|float|bool|\stdClass $value
     *
     * @return $this
     */
    public function addParameter($name, $value)
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Returns given array merged with parameters.
     *
     */
    protected function processArray(array $array = []): array
    {
        return array_merge($array, $this->parameters);
    }
}
