<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Recipient groups') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col gap-4 items-center mb-4">
                        <h1 class="text-3xl">SMS PAGE IS UNDER CONSTRUCTION</h1>
                        <img src="/images/construction.jpg" class="w-1/3" alt="">
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-400 mb-4">
                        <p class="text-gray-400 uppercase font-mono font-bold py-2"
                            style="font-variant: small-caps">
                            {{ __('All items') }}</p>
                    </div>
                    <livewire:binar-table
                        title="You're currently browsing list of all SMSes in the system"
                        :headers="$tableHeaders"
                        :contents="$smses"
                        route="sms"
                        secondaryButtonIcon="fa-trash-can"
                        secondaryButtonTitle="Delete SMS"
                        secondaryButtonAction=""
                        :massDeleteOption="true"
                    />
                    <div class="flex justify-between items-center border-b border-gray-400 my-4 mt-12">
                        <p class="text-gray-400 uppercase font-mono font-bold py-2"
                           style="font-variant: small-caps">
                            {{ __('Creation form') }}</p>
                    </div>
                    <div>
                        <livewire:binar-creation-form route="sms" :fields="[
                                'Message' => ['message', 'textarea'],
                                'Planned sending' => ['plannedSending', 'datetime-local']
                            ]" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
