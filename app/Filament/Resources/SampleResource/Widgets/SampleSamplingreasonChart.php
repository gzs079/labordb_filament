<?php

namespace App\Filament\Resources\SampleResource\Widgets;

use App\Filament\Resources\SampleResource\Pages\ListSamples;
use App\Models\Samplingreason;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;


class SampleSamplingreasonChart extends ChartWidget
{
    use InteractsWithPageTable;

    public function getHeading(): string
    {
        return __('module_names.samplingreason.label');
    }

    //    protected static ?string $pollingInterval = '10s';

    protected int | string | array $columnSpan = 1;

    protected function getTablePage(): string {
        return ListSamples::class;
    }

    protected function getData(): array
    {
        $items = Samplingreason::all();
        $label=[];
        $data=[];
        $backgroundColor=[];

        $index=0;
        foreach ($items as $item) {
            array_push($label, $item->reason);
            array_push($data, $this->getPageTableQuery()->where('samplingreason_id', $item->id)->count());
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
}
