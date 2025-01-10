<?php

namespace App\Filament\Resources\SampleResource\Widgets;

use App\Filament\Resources\SampleResource\Pages\ListSamples;
use App\Models\Sample;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class SampleSamplingDateChart extends ChartWidget
{
    use InteractsWithPageTable;

    public function getHeading(): string
    {
        return __('other.samplingdategraphx');
    }

//    protected static ?string $pollingInterval = '10s';

    protected int | string | array $columnSpan = 1;

    protected function getTablePage(): string {
        return ListSamples::class;
    }

// FILTER WIDGET Y TENGELY BEÁLLÍÁSÁRA, DE GETOPTIONS() NEM MŰKÖDIK
/*    public ?string $filter = 'y_axis_fromzero';

    protected function getFilters(): ?array
    {
        return [
            'y_axis_auto' => __('other.y_axis_auto'),
            'y_axis_fromzero' => __('other.y_axis_fromzero'),
        ];
    }
*/
    protected function getData(): array
    {
        $label=[];
        $data=[];

        $date_min = $this->getPageTableQuery()->min('date_sampling');
        $date_max = $this->getPageTableQuery()->max('date_sampling');

        for ($year = Carbon::parse($date_min)->format('Y'); $year <= Carbon::parse($date_max)->format('Y'); $year++) {
            array_push($label, $year);
            array_push($data, $this->getPageTableQuery()
                                    ->whereDate(
                                        'date_sampling', '>=', Carbon::create($year, 1, 1)->startOfYear()
                                    )
                                    ->whereDate(
                                        'date_sampling', '<=', Carbon::create($year, 12, 31)->endOfYear()
                                    )
                                    ->count());
        }

        return [
            'datasets' => [
                [
                    'label' => __('other.samplingdategraphx'),
                    'data' => $data,
                ],
            ],
            'labels' => $label,
        ];
    }


/************
*   Filament minta alapján
*   InteractsWithPageTable tulajdonságot nem kezeli... csak mintának maradt meg
*   https://filamentphp.com/docs/3.x/widgets/charts#overview
*   https://github.com/Flowframe/laravel-trend
************/
    protected function getData_NEMJO(): array
    {
        $data = Trend::model(Sample::class)
        ->dateColumn('date_sampling')
        ->between(
            start:  Carbon::now()->subYears(4),//now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perYear()
        ->count();

        return [
            'datasets' => [
                [
                    'label' => __('other.samplingdategraphx'),
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }


    protected function getOptions(): array
    {

//beállítások módosításával getOptions() lefut, de widhegetet beállításai nem változnak
//lásd még:        getOptions() on chart widget - called but not reflected on the the chart #9918

/*
        if ($this->filter==='y_axis_fromzero') {
            return [
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                            'ticks' => [
                                'precision' => 0, // Ha szükséges, hogy kerek számok legyenek a tengelyen
                            ],
                    ],
                ],
            ];
        }
*/

        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => false,
                        'ticks' => [
                            'precision' => 0, // Ha szükséges, hogy kerek számok legyenek a tengelyen
                        ],
                ],
            ],
        ];


    }

}
