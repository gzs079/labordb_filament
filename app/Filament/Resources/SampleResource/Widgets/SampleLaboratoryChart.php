<?php

namespace App\Filament\Resources\SampleResource\Widgets;

use App\Filament\Resources\SampleResource\Pages\ListSamples;
use App\Models\Laboratory;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class SampleLaboratoryChart extends ChartWidget
{
    use InteractsWithPageTable;

    public function getHeading(): string
    {
        return __('module_names.laboratory.label');
    }

        protected static ?string $pollingInterval = '100s';

    protected int | string | array $columnSpan = 1;

    protected function getTablePage(): string {
        return ListSamples::class;
    }

    protected function getData(): array
    {
        $items = Laboratory::all()->pluck('name', 'laboratory')->unique();
        $label=[];
        $data=[];
        $backgroundColor=[];

        $index=0;
        //collection kulcs-érték párjainak lekérdezése $laboratory => $name formátumban.....
        foreach ($items as $laboratory => $name) {
            array_push($label, $name);
            array_push($data, $this->getPageTableQuery()
                                    ->whereHas(
                                        'laboratory',
                                        fn ($query) => $query->where('laboratory', $laboratory)
                                    )
                                    ->count());
            array_push($backgroundColor, generateColor($index)['total'] < count($items) ? generateHSLColor($index, count($items)) : generateColor($index)['color']);
            $index++;
        }

        return [
            'labels' => $label,
            'datasets' => [
                [
                    'label' => 'My First Dataset',
                    'data' => $data,
                    'backgroundColor' => $backgroundColor,
                    'hoverOffset' => 10,
                ],
            ],
        ];

    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected static ?array $options = [
        'scales' => [
            'y' => [
                'grid' => [
                    'display' => false,
                ],
                'ticks' => [
                    'display' => false,
                ],
            ],
            'x' => [
                'grid' => [
                    'display' => false,
                ],
                'ticks' => [
                    'display' => false,
                ],
            ],
        ],
    ];
}
