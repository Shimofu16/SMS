<div class="flex items-center justify-center bg-gray-100">
    <div class="mx-auto mt-10 sm:mt-[100px]">
        <div class="py-5 mb-5 text-white bg-blue-600 rounded-lg heading">
            <h1 class="text-xl font-bold text-center">Enrollment Form</h1>
            <h1 class="text-lg font-bold text-center">SY:{{ $school_year->schoolYear->slug }}</h1>
        </div>
        <form wire:submit="create">
            <div class="body">
                {{ $this->form }}
            </div>
            {{-- <div class="flex justify-between mt-4 footer">
                <div></div>
                <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Submit
                </button>
            </div> --}}
        </form>
    </div>
</div>
