<?php

namespace App\Filament\Resources\SampleResource\Widgets;

use App\Filament\Resources\SampleResource\Pages\ListSamples;
use App\Models\Settlement;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class SampleSettlementChart extends ChartWidget
{
    use InteractsWithPageTable;

    public function getHeading(): string
    {
        return __('module_names.settlement.label');
    }

    //    protected static ?string $pollingInterval = '10s';

    protected int | string | array $columnSpan = 1;

    protected function getTablePage(): string {
        return ListSamples::class;
    }

    protected function getData(): array
    {
        $items = Settlement::all();
        $label=[];
        $data=[];
        $backgroundColor=[];

        $index=0;

        foreach ($items as $item) {
            array_push($label, $item->settlement);
            array_push($data, $this->getPageTableQuery()
                                    ->whereHas(
                                        'samplingsite',
                                        fn ($query) => $query->whereHas(
                                            'settlement',
                                            fn ($query) => $query->where('id', $item->id)
                                        )
                                    )
                                    ->count());
            array_push($backgroundColor, (generateColor(0)['total'] < count($items)) ? generateHSLColor($index, count($items)) : generateColor($index)['color']);
            $index++;
        }

        return [
            'labels' => $label,
            'datasets' => [
                [
                    'label' => __('other.settlementgraphx'),
                    'data' => $data,
                    'backgroundColor' => $backgroundColor,
                    'hoverOffset' => 10,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
