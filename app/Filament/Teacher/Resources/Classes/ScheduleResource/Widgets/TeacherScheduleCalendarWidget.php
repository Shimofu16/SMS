<?php

namespace App\Filament\Teacher\Resources\Classes\ScheduleResource\Widgets;

use App\Models\ScheduleClass;
use Illuminate\Support\Facades\Auth;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class TeacherScheduleCalendarWidget extends FullCalendarWidget
{
    /**
     * FullCalendar will call this function whenever it needs new event data.
     * This is triggered when the user clicks prev/next or switches views on the calendar.
     */
    public function fetchEvents(array $fetchInfo): array
    {
        $setting = getCurrentSetting();
        return ScheduleClass::query()
            ->with('schedule')
            ->whereHas('schedule', function ($query) use ($setting) {
                $query->where('school_year_id', $setting->school_year_id)
                    ->where('teacher_id', Auth::user()->teacher_id);
            })
            ->get()
            ->map(
                fn (ScheduleClass $class) => [
                    'title' => $class->schedule->subject->name,
                    'start' => date('Y-m-d\TH:i:s', strtotime($class->date . ' ' . $class->start)),
                    'end' => date('Y-m-d\TH:i:s', strtotime($class->date . ' ' . $class->end))
                ]
            )

            ->all();
    }
}
