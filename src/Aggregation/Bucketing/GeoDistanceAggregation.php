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
namespace ONGR\ElasticsearchDSL\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\BucketingTrait;

/**
 * Class representing geo distance aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-geodistance-aggregation.html
 */
class GeoDistanceAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var mixed
     */
    private $origin;

    /**
     * @var string
     */
    private $distanceType;

    /**
     * @var string
     */
    private $unit;

    private array $ranges = [];

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     * @param mixed  $origin
     * @param array  $ranges
     * @param string $unit
     * @param string $distanceType
     */
    public function __construct($name, $field = null, $origin = null, $ranges = [], $unit = null, $distanceType = null)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setOrigin($origin);
        foreach ($ranges as $range) {
            $from = $range['from'] ?? null;
            $to = $range['to'] ?? null;
            $this->addRange($from, $to);
        }
        $this->setUnit($unit);
        $this->setDistanceType($distanceType);
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param mixed $origin
     *
     * @return $this
     */
    public function setOrigin($origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * @return string
     */
    public function getDistanceType()
    {
        return $this->distanceType;
    }

    /**
     * @param string $distanceType
     *
     * @return $this
     */
    public function setDistanceType($distanceType): static
    {
        $this->distanceType = $distanceType;

        return $this;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     *
     * @return $this
     */
    public function setUnit($unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Add range to aggregation.
     *
     * @param int|float|null $from
     * @param int|float|null $to
     *
     *
     * @throws \LogicException
     */
    public function addRange($from = null, $to = null): static
    {
        $range = array_filter(
            [
                'from' => $from,
                'to'   => $to,
            ],
            fn ($v): bool => !is_null($v)
        );

        if ($range === []) {
            throw new \LogicException('Either from or to must be set. Both cannot be null.');
        }

        $this->ranges[] = $range;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        $data = [];

        if ($this->getField()) {
            $data['field'] = $this->getField();
        } else {
            throw new \LogicException('Geo distance aggregation must have a field set.');
        }

        if ($this->getOrigin()) {
            $data['origin'] = $this->getOrigin();
        } else {
            throw new \LogicException('Geo distance aggregation must have an origin set.');
        }

        if ($this->getUnit()) {
            $data['unit'] = $this->getUnit();
        }

        if ($this->getDistanceType()) {
            $data['distance_type'] = $this->getDistanceType();
        }

        $data['ranges'] = $this->ranges;

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'geo_distance';
    }
}
