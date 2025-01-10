<?php

namespace App\Filament\Resources\SampleResource\Widgets;

use App\Filament\Resources\SampleResource\Pages\ListSamples;
use App\Models\Result;
use App\Models\Sample;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class SampleResultsNumbereChart extends ChartWidget
{
    use InteractsWithPageTable;

    public function getHeading(): string
    {
        return __('other.resultsnumbergraphx');
    }

//    protected static ?string $pollingInterval = '10s';

    protected int | string | array $columnSpan = 1;

    protected function getTablePage(): string {
        return ListSamples::class;
    }

    protected function getData(): array
    {
        $items = Result::all();
        $samples = Sample::all();

        $label=[];
        $data=[];

        $date_min = $this->getPageTableQuery()->min('date_sampling');
        $date_max = $this->getPageTableQuery()->max('date_sampling');

        for ($year = Carbon::parse($date_min)->format('Y'); $year <= Carbon::parse($date_max)->format('Y'); $year++) {
            array_push($label, $year);

            $samples_in_year = $this->getPageTableQuery()
                                    ->whereDate(
                                        'date_sampling', '>=', Carbon::create($year, 1, 1)->startOfYear()
                                    )
                                    ->whereDate(
                                        'date_sampling', '<=', Carbon::create($year, 12, 31)->endOfYear()
                                    )
                                    ->get();


            array_push($data, $items->whereIn('sample_id', $samples_in_year->pluck('id'))->count());
        }

//PROBLÉMA: Y TENGELY SKÁLÁJÁNAK ÁLLÍTÁSA NEM MŰKÖDIK
        return [
            'datasets' => [
                [
                    'label' => __('other.resultsnumbergraphx'),
                    'data' => $data,
                ],
            ],
            'labels' => $label,
            'options' => [
                'responsive' => true,
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'ticks' => [
                            'precision' => 0, // Ha szükséges, hogy kerek számok legyenek a tengelyen
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
