<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="grid w-full grid-cols-1 gap-6 mb-6 xl:grid-cols-2 2xl:grid-cols-4">
            <div class="p-4 bg-white shadow-lg shadow-gray-200 rounded-2xl ">
                <div class="flex items-center">
                    <div
                        class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 text-black rounded-lg shadow-md bg-gradient-to-br from-white-500 to-voilet-500 shadow-gray-300">

                        <i class="text-lg fa-solid fa-user-graduate"></i>
                    </div>
                    <div class="flex-shrink-0 ml-3">
                        <span class="text-2xl font-bold leading-none text-gray-900">{{ $enrolledCount }}</span>
                        <h3 class="text-base font-normal text-gray-500">Enrolled Students</h3>
                    </div>
                </div>
            </div>
            <div class="p-4 bg-white shadow-lg shadow-gray-200 rounded-2xl ">
                <div class="flex items-center">
                    <div
                        class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 text-black rounded-lg shadow-md bg-gradient-to-br from-white-500 to-voilet-500 shadow-gray-300">
                        <i class="text-lg fa-solid fa-graduation-cap"></i>
                    </div>
                    <div class="flex-shrink-0 ml-3">
                        <span class="text-2xl font-bold leading-none text-gray-900">{{ $enrolleeCount }}</span>
                        <h3 class="text-base font-normal text-gray-500">Enrollee Students</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap mt-6 -mx-3">
            <div class="w-full max-w-full mt-0 mb-6 lg:mb-0 lg:w-7/12">
                <div
                    class="relative flex flex-col min-w-0 p-3 pt-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
                    <div class="p-4 pb-0 mb-0 rounded-t-4">
                        <div class="flex justify-between">
                            <h6 class="mb-2 dark:text-white">
                                <strong>Students Per School Year</strong>
                            </h6>
                        </div>
                    </div>
                    <div class="ps" style="height: 20rem;">
                        <livewire:livewire-column-chart key="{{ $studentsColumnChart->reactiveKey() }}" :column-chart-model="$studentsColumnChart" />
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mt-0 lg:w-5/12">
                <div
                    class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                    <div class="p-4 pb-0 rounded-t-4">
                        <h6 class="mb-0 dark:text-white">
                            <strong>Recent Enrollees</strong>
                        </h6>
                    </div>
                    <div class="flex-auto p-4 pb-1">
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                            @foreach ($recentEnrollees as $recentEnrollee)
                            <li
                                class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-t-lg rounded-xl text-inherit" wire:key='{{ $recentEnrollee->id }}'>
                                <div class="flex items-center">

                                    <div class="flex flex-col">
                                        <h6 class="mb-1 text-sm leading-normal text-slate-700 dark:text-white">
                                            <strong>Name:</strong>
                                            {{ $recentEnrollee->full_name }}
                                        </h6>
                                        <span class="text-xs leading-tight dark:text-white/80">
                                            <strong>Grade Level:</strong>
                                               {{ $recentEnrollee->enrollment->gradeLevel->name }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex">
                                    <span class="text-xs leading-tight dark:text-white/80">{{ $recentEnrollee->created_at->diffForHumans() }}</span>
                                </div>
                            </li>

                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap mt-6 -mx-3">
            <div class="w-full max-w-full mt-0 mb-6 lg:mb-0 lg:w-7/12">
                <div
                    class="relative flex flex-col min-w-0 p-3 pt-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
                    <div class="p-4 pb-0 mb-0 rounded-t-4">
                        <div class="flex justify-between">
                            <h6 class="mb-2 dark:text-white">
                                <strong>Enrollee Students Per Department - SY: {{ getCurrentSetting()->schoolYear->slug }}</strong>
                            </h6>
                        </div>
                    </div>
                    <div class="ps" style="height: 20rem;">
                        <livewire:livewire-column-chart key="{{ $enrolleePerDepartment->reactiveKey() }}" :column-chart-model="$enrolleePerDepartment" />
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mt-0 lg:w-5/12">
                <div
                    class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                    <div class="p-4 pb-5 rounded-t-4">
                        <h6 class="mb-0 dark:text-white">
                            <strong>Enrollee Students Per Types - SY: {{ getCurrentSetting()->schoolYear->slug }}</strong>
                        </h6>
                    </div>
                    <div class="flex-auto p-4" style="height: 20rem;">
                        <livewire:livewire-pie-chart key="{{ $enrolleePerType->reactiveKey() }}" :pie-chart-model="$enrolleePerType" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
