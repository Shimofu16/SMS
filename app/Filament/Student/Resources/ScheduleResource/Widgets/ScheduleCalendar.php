<?php

namespace App\Filament\Student\Resources\ScheduleResource\Widgets;

use App\Models\ScheduleClass;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class ScheduleCalendar extends  FullCalendarWidget
{
    /**
     * FullCalendar will call this function whenever it needs new event data.
     * This is triggered when the user clicks prev/next or switches views on the calendar.
     */
    public function fetchEvents(array $fetchInfo): array
    {
        return ScheduleClass::query()
            ->with('schedule')
            ->whereHas('schedule', function ($query) {
                $query->where('section_id', Auth::user()->student->enrollment->section_id);
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
