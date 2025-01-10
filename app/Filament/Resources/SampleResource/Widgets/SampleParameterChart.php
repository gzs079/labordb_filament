<?php

namespace App\Filament\Resources\SampleResource\Widgets;

use App\Filament\Resources\SampleResource\Pages\ListSamples;
use App\Models\Parameter;
use App\Models\Result;
use App\Models\Sample;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Illuminate\Support\Facades\DB;

class SampleParameterChart extends ChartWidget
{
    use InteractsWithPageTable;

    public function getHeading(): string
    {
        return __('module_names.parameter.label');
    }

    //protected static ?string $pollingInterval = '10s';

    protected int | string | array $columnSpan = 1;

    protected function getTablePage(): string {
        return ListSamples::class;
    }

    public ?string $filter = '10';

    protected function getFilters(): ?array
    {
        return [
            '5' => 5,
            '10' => 10,
            '15' => 15,
            '20' => 20,
        ];
    }

    protected function getData(): array
    {
        $number_of_parameters = $this->filter;

        $parameters = Parameter::all();

        //szűrt minták lekérdezése
        $samples = $this->getPageTableQuery()->get();


        $results = DB::table('results')
            ->selectRaw('count(id) as count_of_measurements, parameter_id')
            ->whereIn('sample_id', $samples->pluck('id'))
            ->groupBy('parameter_id')
            ->orderBy('count_of_measurements', 'desc')
            ->limit($number_of_parameters)
            ->get();
/*        $x=[];
        foreach ($results as $result) {
            array_push($x,$result->sample_id . '-' . $result->parameter_id);
        }*/
        //return [];
        //dd($results);


        $label=[];
        $data=[];
        $backgroundColor=[];

        $index=0;

        foreach ($results as $result) {
            array_push($label, Parameter::where('id',$result->parameter_id)->firstOrFail()->description_labor);
            array_push($data, $result->count_of_measurements);
            array_push($backgroundColor, (generateColor(0)['total'] < $number_of_parameters) ? generateHSLColor($index, $number_of_parameters) : generateColor($index)['color']);
            $index++;
        }

        return [
            'datasets' => [
                [
                    'label' => __('other.resultsnumbergraphx'),
                    'backgroundColor' => $backgroundColor,
                    'data' => $data,
                ],
            ],
            'labels' => $label,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
