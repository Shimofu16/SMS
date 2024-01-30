<div class="bg-gray-100  flex justify-center items-center">
    <div class="mx-auto mt-10 sm:mt-[100px]">
        <div class="heading mb-5 bg-blue-600 rounded-lg py-5 text-white">
            <h1 class="text-center text-xl font-bold">Enrollment Form</h1>
            <h1 class="text-center text-lg font-bold">SY:2024-2025</h1>
        </div>
        <form wire:submit="create">
            <div class="body">
                {{ $this->form }}
            </div>
            {{-- <div class="footer flex justify-between mt-4">
                <div></div>
                <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Submit
                </button>
            </div> --}}
        </form>
    </div>
</div>
