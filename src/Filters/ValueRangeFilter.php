<?php

namespace Tapp\FilamentValueRangeFilter\Filters;

use Closure;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Number;
use Tapp\FilamentValueRangeFilter\Concerns\HasCurrency;

class ValueRangeFilter extends Filter
{
    use HasCurrency;

    protected ?string $indicatorBetweenLabel = null;

    protected ?string $indicatorEqualLabel = null;

    protected ?string $indicatorGreaterThanLabel = null;

    protected ?string $indicatorLessThanLabel = null;

    protected string|Closure $locale = 'en';

    protected function setUp(): void
    {
        parent::setup();

        $this
            ->form(fn () => [
                Forms\Components\Fieldset::make($this->getlabel())
                    ->schema([
                        Forms\Components\Select::make('range_condition')
                            ->hiddenLabel()
                            ->placeholder(__('filament-value-range-filter::filament-value-range-filter.range.placeholder'))
                            ->live()
                            ->options([
                                'equal' => __('filament-value-range-filter::filament-value-range-filter.range.options.equal'),
                                'between' => __('filament-value-range-filter::filament-value-range-filter.range.options.between'),
                                'greater_than' => __('filament-value-range-filter::filament-value-range-filter.range.options.greater_than'),
                                'less_than' => __('filament-value-range-filter::filament-value-range-filter.range.options.less_than'),
                            ])
                            ->afterStateUpdated(function (Set $set) {
                                $set('range_equal', null);
                                $set('range_between_from', null);
                                $set('range_between_to', null);
                                $set('range_greater_than', null);
                                $set('range_less_than', null);
                            }),
                        Forms\Components\TextInput::make('range_equal')
                            ->hiddenLabel()
                            ->numeric()
                            ->placeholder(fn (): string => $this->getFormattedValue(0))
                            ->visible(fn (Get $get): bool => $get('range_condition') === 'equal' || empty($get('range_condition'))),
                        Forms\Components\Grid::make([
                            'default' => 1,
                            'sm' => 2,
                        ])
                            ->schema([
                                Forms\Components\TextInput::make('range_between_from')
                                    ->hiddenLabel()
                                    ->numeric()
                                    ->placeholder(fn (): string => $this->getFormattedValue(0)),
                                Forms\Components\TextInput::make('range_between_to')
                                    ->hiddenLabel()
                                    ->numeric()
                                    ->placeholder(fn (): string => $this->getFormattedValue(0)),
                            ])
                            ->visible(fn (Get $get): bool => $get('range_condition') === 'between'),
                        Forms\Components\TextInput::make('range_greater_than')
                            ->hiddenLabel()
                            ->numeric()
                            ->placeholder(fn (): string => $this->getFormattedValue(0))
                            ->visible(fn (Get $get): bool => $get('range_condition') === 'greater_than'),
                        Forms\Components\TextInput::make('range_less_than')
                            ->hiddenLabel()
                            ->numeric()
                            ->placeholder(fn (): string => $this->getFormattedValue(0))
                            ->visible(fn (Get $get): bool => $get('range_condition') === 'less_than'),
                    ])
                    ->columns(1),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['range_equal'],
                        fn (Builder $query, $value): Builder => $query->where($this->getName(), '=', $this->getValue($value)),
                    )
                    ->when(
                        $data['range_between_from'] && $data['range_between_to'],
                        function (Builder $query, $value) use ($data) {
                            $query->where($this->getName(), '>=', $this->getValue($data['range_between_from']))->where($this->getName(), '<=', $this->getValue($data['range_between_to']));
                        },
                    )
                    ->when(
                        $data['range_greater_than'],
                        fn (Builder $query, $value): Builder => $query->where($this->getName(), '>', $this->getValue($value)),
                    )
                    ->when(
                        $data['range_less_than'],
                        fn (Builder $query, $value): Builder => $query->where($this->getName(), '<', $this->getValue($value)),
                    );
            })
            ->indicateUsing(function (array $data): array {
                $indicators = [];

                if ($data['range_between_from'] || $data['range_between_to']) {
                    $indicators[] = Indicator::make(__('filament-value-range-filter::filament-value-range-filter.range.indicator.between', [
                        'label' => $this->getIndicatorBetweenLabel() ?? $this->getLabel(),
                        'fromValue' => $this->getFormattedValue($data['range_between_from']),
                        'toValue' => $this->getFormattedValue($data['range_between_to']),
                    ]))
                        ->removeField('range_between_from')
                        ->removeField('range_between_to');
                }

                if ($data['range_equal']) {
                    $indicators[] = Indicator::make(__('filament-value-range-filter::filament-value-range-filter.range.indicator.equal', [
                        'label' => $this->getIndicatorEqualLabel() ?? $this->getLabel(),
                        'value' => $this->getFormattedValue($data['range_equal'])
                    ]))
                        ->removeField('range_equal');
                }

                if ($data['range_greater_than']) {
                    $indicators[] = Indicator::make(__('filament-value-range-filter::filament-value-range-filter.range.indicator.greater_than', [
                        'label' => $this->getIndicatorGreaterThanLabel() ?? $this->getLabel(),
                        'value' => $this->getFormattedValue($data['range_greater_than'])
                    ]))
                        ->removeField('range_greater_than');
                }

                if ($data['range_less_than']) {
                    $indicators[] = Indicator::make(__('filament-value-range-filter::filament-value-range-filter.range.indicator.less_than', [
                        'label' => $this->getIndicatorLessThanLabel() ?? $this->getLabel(),
                        'value' => $this->getFormattedValue($data['range_less_than'])
                    ]))
                        ->removeField('range_less_than');
                }

                return $indicators;
            });
    }

    protected function getValue($value)
    {
        if ($this->isCurrency()) {
            return $this->isCurrencyInSmallestUnit ? $value * 100 : $value;
        }

        return $value;
    }

    protected function getFormattedValue($value)
    {
        if ($this->isCurrency() && $value !== null) {
            return $this->isCurrency ? Number::currency($value, in: $this->currencyCode, locale: $this->locale) : $value;
        }

        return $value;
    }

    public function indicatorBetweenLabel(?string $label): static
    {
        $this->indicatorBetweenLabel = $label;

        return $this;
    }

    public function getIndicatorBetweenLabel(): ?string
    {
        return $this->evaluate($this->indicatorBetweenLabel);
    }

    public function indicatorEqualLabel(?string $label): static
    {
        $this->indicatorEqualLabel = $label;

        return $this;
    }

    public function getIndicatorEqualLabel(): ?string
    {
        return $this->evaluate($this->indicatorEqualLabel);
    }

    public function indicatorGreaterThanLabel(?string $label): static
    {
        $this->indicatorGreaterThanLabel = $label;

        return $this;
    }

    public function getIndicatorGreaterThanLabel(): ?string
    {
        return $this->evaluate($this->indicatorGreaterThanLabel);
    }

    public function indicatorLessThanLabel(?string $label): static
    {
        $this->indicatorLessThanLabel = $label;

        return $this;
    }

    public function getIndicatorLessThanLabel(): ?string
    {
        return $this->evaluate($this->indicatorLessThanLabel);
    }

    public function locale(string|Closure $locale = 'en'): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->evaluate($this->locale);
    }
}
