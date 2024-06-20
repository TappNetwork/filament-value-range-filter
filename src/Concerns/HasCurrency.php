<?php

namespace Tapp\FilamentValueRangeFilter\Concerns;

use Closure;

trait HasCurrency
{
    protected bool|Closure $isCurrency = false;

    protected bool|Closure $isCurrencyInSmallestUnit = true;

    protected string|Closure $currencyCode = 'USD';

    public function currency(bool|Closure $condition = true): static
    {
        $this->isCurrency = $condition;

        return $this;
    }

    public function isCurrency(): bool
    {
        return (bool) $this->evaluate($this->isCurrency);
    }

    public function currencyInSmallestUnit(bool|Closure $condition = true): static
    {
        $this->isCurrencyInSmallestUnit = $condition;

        return $this;
    }

    public function isCurrencyInSmallestUnit(): bool
    {
        return (bool) $this->evaluate($this->isCurrencyInSmallestUnit);
    }

    /**
     * ISO 4217 currency code
     *
     * @see https://www.php.net/manual/en/numberformatter.formatcurrency.php
     * @see https://www.iban.com/currency-codes
     */
    public function currencyCode(string|Closure $currencyCode = 'USD'): static
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    public function getCurrencyCode(): string
    {
        return $this->evaluate($this->currencyCode);
    }
}
