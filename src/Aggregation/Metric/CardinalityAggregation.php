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
namespace ONGR\ElasticsearchDSL\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;
use ONGR\ElasticsearchDSL\ScriptAwareTrait;

/**
 * Difference values counter.
 *
 * @see http://goo.gl/tG7ciG
 */
class CardinalityAggregation extends AbstractAggregation
{
    use MetricTrait;
    use ScriptAwareTrait;

    /**
     * @var int
     */
    private $precisionThreshold;

    /**
     * @var bool
     */
    private $rehash;

    /**
     * {@inheritdoc}
     * @return mixed[]
     */
    public function getArray(): array
    {
        $out = array_filter(
            [
                'field'               => $this->getField(),
                'script'              => $this->getScript(),
                'precision_threshold' => $this->getPrecisionThreshold(),
                'rehash'              => $this->isRehash(),
            ],
            fn ($val): bool => $val || is_bool($val)
        );

        $this->checkRequiredFields($out);

        return $out;
    }

    /**
     * @param int $precision
     *
     * @return $this
     */
    public function setPrecisionThreshold($precision): static
    {
        $this->precisionThreshold = $precision;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrecisionThreshold()
    {
        return $this->precisionThreshold;
    }

    /**
     * @return bool
     */
    public function isRehash()
    {
        return $this->rehash;
    }

    /**
     * @param bool $rehash
     *
     * @return $this
     */
    public function setRehash($rehash): static
    {
        $this->rehash = $rehash;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'cardinality';
    }

    /**
     * Checks if required fields are set.
     *
     *
     * @throws \LogicException
     */
    private function checkRequiredFields(array $fields): void
    {
        if (!array_key_exists('field', $fields) && !array_key_exists('script', $fields)) {
            throw new \LogicException('Cardinality aggregation must have field or script set.');
        }
    }
}
