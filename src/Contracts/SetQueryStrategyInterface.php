<?php

namespace Smetaniny\ReactAdminRouting\Contracts;

interface SetQueryStrategyInterface
{
    /**
     * Изменение стратегии
     *
     * @param QueryStrategyInterface $strategy
     *
     * @return $this
     */
    public function setQueryStrategy(QueryStrategyInterface $strategy): self;
}
