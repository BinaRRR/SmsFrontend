<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Recipient groups | Edit mode') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-xl text-center">
                        {{ __('You are currently editing recipient group: :name', ['name' => $recipientGroup['name']]) }}
                    </h1>
                    <div class="py-4">
                        <div class="flex flex-col gap-2">
                            <div class="flex justify-between items-center border-b border-gray-400 my-4">
                                <p class="text-gray-400 uppercase font-mono font-bold" style="font-variant: small-caps">
                                    {{ __('Details') }}</p>
                                <button class="hover:bg-green-600 transition-colors text-white grid place-items-center">
                                    <p class="uppercase px-2 py-2 font-bold">
                                        Save &nbsp; <i class="fa-solid fa-floppy-disk"></i>
                                    </p>
                                </button>
                            </div>
                            <div>

                                <div class="py-1 px-4 gap-4 flex flex-row justify-between items-center">
                                    <div>
                                        <p class="text-lg font-bold">Id: </p>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <p class="text-lg"> {{ $recipientGroup['id'] }}</p>
                                    </div>
                                </div>
                                <div class="py-1 px-4 gap-4 flex flex-row justify-between items-center">
                                    <div>
                                        <p class="text-lg font-bold">Name: </p>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <p class="text-lg"> {{ $recipientGroup['name'] }}</p>
                                        <button class="grid place-items-center aspect-square p-2 rounded-md bg-blue-500">
                                            <i class="text-white fa-solid fa-pen-to-square "></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="py-1 px-4 gap-4 flex flex-row justify-between items-center">
                                    <div>
                                        <p class="text-lg font-bold">Description: </p>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <p class="text-lg"> {{ $recipientGroup['description'] }}</p>
                                        <button class="grid place-items-center aspect-square p-2 rounded-md bg-blue-500">
                                            <i class="text-white fa-solid fa-pen-to-square "></i>
                                        </button>
                                        {{-- <button class="grid place-items-center aspect-square p-2 rounded-md bg-red-600">
                                            <i class="text-white fa-solid fa-trash-can"></i>
                                        </button> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-400 my-4">
                                <p class="text-gray-400 uppercase font-mono font-bold" style="font-variant: small-caps">
                                    {{ __('Group memberships') }}</p>
                                <button class="hover:bg-green-600 transition-colors text-white grid place-items-center">
                                    <p class="uppercase px-2 py-2 font-bold">
                                        Save &nbsp; <i class="fa-solid fa-floppy-disk"></i>
                                    </p>
                                </button>
                            </div>
                            <livewire:binar-table
                                title=""
                                :headers="$tableHeaders"
                                :contents="$tableContents"
                                route="recipient"
                                secondaryButtonIcon="fa-xmark"
                                secondaryButtonAction="/add-to-group"
                                secondaryButtonTitle="Exit group"
                            />
                            <div class="flex justify-between items-center border-b border-gray-400 my-4 mt-12">
                                <p class="text-gray-400 uppercase font-mono font-bold py-2" style="font-variant: small-caps">
                                    {{ __('Actions') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
