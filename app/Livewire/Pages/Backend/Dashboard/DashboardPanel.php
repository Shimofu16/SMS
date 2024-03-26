<?php

namespace App\Livewire\Pages\Backend\Dashboard;

use App\Enums\StudentEnrollmentPaymentStatus;
use App\Enums\StudentEnrollmentStatusEnum;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\StudentEnrollment;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Attributes\On;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Carbon\Carbon;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DashboardPanel extends Component
{
    public $colors;
    /*
    $pieChartModel = $expenses->groupBy('type')
            ->reduce(function ($pieChartModel, $data) {
                $type = $data->first()->type;
                $value = $data->sum('amount');

                return $pieChartModel->addSlice($type, $value, $this->colors[$type]);
            }, LivewireCharts::pieChartModel()
                //->setTitle('Expenses by Type')
                ->setAnimated($this->firstRun)
                ->setType('donut')
                ->withOnSliceClickEvent('onSliceClick')
                //->withoutLegend()
                ->legendPositionBottom()
                ->legendHorizontallyAlignedCenter()
                ->setDataLabelsEnabled($this->showDataLabels)
                ->setColors(['#b01a1b', '#d41b2c', '#ec3c3b', '#f66665'])
            );

     */
    #[On('enrolleeStudentsColumnChartOnColumnClick')]
    public function handleOnColumnClick($event)
    {
        dd($event);
    }

    private function getColor($colors = null)
    {
        $stockColors = [
            '#1f77b4', // blue
            '#ff7f0e', // orange
            '#2ca02c', // green
            '#d62728', // red
            '#9467bd', // purple
            '#8c564b', // brown
            '#e377c2', // pink
            '#7f7f7f', // gray
            '#bcbd22', // yellow-green
            '#17becf', // cyan
            '#1a9850', // green
            '#66bd63', // green
            '#a6d96a', // green
            '#d9ef8b', // yellow-green
            '#fdae61', // orange
            '#f46d43', // orange
            '#d73027', // red
            '#a50026', // red
            '#ffeda0', // yellow
            '#737373', // gray
        ];

        $uniqueColors = [];

        if ($colors) {
            // Iterate over each color in $colors
            foreach ($colors as $color) {
                // Check if the color exists in $stockColors and is not already added to $uniqueColors
                if (in_array($color, $stockColors) && !in_array($color, $uniqueColors)) {
                    return $color; // Add the unique color to $uniqueColors
                }
            }
        }
        return $stockColors;
    }
    public function render()
    {
        $setting = getCurrentSetting();
        $slug = explode('-', $setting->schoolYear->slug);
        $slug[0] = Carbon::parse($slug[0])->format('Y');
        $slug[1] = Carbon::parse($slug[1])->format('Y');

        $schoolYear = SchoolYear::withCount('studentEnrollments')
            ->whereHas('studentEnrollments', function ($query) use ($slug) {
                $query
                    ->whereYear('created_at', $slug[0])
                    ->orWhereYear('created_at', $slug[1]);
            })
            ->get();
        $departments = collect(getDepartments($setting));
        $types = collect(getStudentTypes($setting));

        return view('livewire.pages.backend.dashboard.dashboard-panel', [
            
            'recentEnrollees' => Student::with(['enrollments' => function ($query) use ($setting) {
                $query->where('school_year_id', $setting->school_year_id)
                    ->whereDate('created_at', '>=', now()->subDays(30)); // Select enrollees within the last 30 days
            }])
                ->whereHas('enrollments', function ($query) use ($setting) {
                    $query->where('school_year_id', $setting->school_year_id);
                })
                ->limit(5)
                ->get(),
            'enrolleeCount' => Student::query()->with('enrollments')
                ->whereHas('enrollments', function ($query) use ($setting) {
                    $query
                        ->where('school_year_id', $setting->school_year_id)
                        ->where('status', StudentEnrollmentStatusEnum::PENDING->value);
                })
                ->count(),
            'enrolledCount' => Student::query()->with('enrollments')
                ->whereHas('enrollments', function ($query) use ($setting) {
                    $query
                        ->where('school_year_id', $setting->school_year_id)
                        ->where('status', StudentEnrollmentStatusEnum::ACCEPTED->value);
                })
                ->count(),
                'studentsColumnChart' => $schoolYear->groupBy('id')
                ->reduce(
                    function ($studentsColumnChart, $data) {
                        $school_year = $data->first()->slug;
                        $count = $data->first()->student_enrollments_count;
                        $this->colors[$school_year] = $this->getColor($this->colors);
                        return $studentsColumnChart->addColumn($school_year, $count, $this->colors[$school_year]);
                    },
                    LivewireCharts::columnChartModel()
                        ->setAnimated(true)
                        ->setLegendVisibility(true)
                        ->setDataLabelsEnabled(true)
                        //->setOpacity(0.25)
                        ->setColumnWidth(90)
                        ->withGrid()
                        ->setColors($this->getColor())
                ),
            'enrolleePerDepartment' =>  $departments->groupBy('department')
                ->reduce(
                    function ($studentsColumnChart, $data) {
                        $department = $data->first()->department;
                        $count = $data->first()->count;
                        $this->colors[$department] = $this->getColor($this->colors);
                        return $studentsColumnChart->addColumn($department, $count, $this->colors[$department]);
                    },
                    LivewireCharts::columnChartModel()

                        ->setAnimated(true)
                        ->setLegendVisibility(true)
                        ->setDataLabelsEnabled(true)
                        //->setOpacity(0.25)
                        ->setColumnWidth(90)
                        ->withGrid()
                        ->setColors($this->getColor())
                ),
            'enrolleePerType' =>   $types->groupBy('student_type')
                ->reduce(
                    function ($pieChartModel, $data) {
                        $type = $data->first()->student_type;
                        $count = $data->first()->count;
                        $this->colors[$type] = $this->getColor($this->colors);
                        return $pieChartModel->addSlice($type, $count, $this->colors[$type]);
                    },
                    LivewireCharts::pieChartModel()
                        ->setAnimated(true)
                        ->setLegendVisibility(true)
                        ->setDataLabelsEnabled(true)
                        ->setType('donut')
                        //->withoutLegend()
                        ->legendPositionBottom()
                        ->legendHorizontallyAlignedCenter()
                        ->setColors($this->getColor())
                ),
        ]);
    }
}
