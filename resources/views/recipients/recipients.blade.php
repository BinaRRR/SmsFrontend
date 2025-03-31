<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Recipients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center border-b border-gray-400 mb-4">
                        <p class="text-gray-400 uppercase font-mono font-bold py-2"
                            style="font-variant: small-caps">
                            {{ __('All items') }}</p>
                    </div>
                    <livewire:binar-table
                        title="You're currently browsing list of all recipients in the system"
                        :headers="['Full name', 'Phone number']"
                        :contents="$recipients"
                        route="recipient"
                        secondaryButtonIcon="fa-trash-can"
                        secondaryButtonTitle="Delete recipient"
                        secondaryButtonAction=""
                        :massDeleteOption="true"
                    />
                    <div class="flex justify-between items-center border-b border-gray-400 my-4 mt-12">
                        <p class="text-gray-400 uppercase font-mono font-bold py-2"
                            style="font-variant: small-caps">
                            {{ __('Creation form') }}</p>
                    </div>
                    <div>
                        <livewire:binar-creation-form route="recipient" :fields="[
                                'Full Name' => ['fullName', 'text'],
                                'Phone Number' => ['phoneNumber', 'text']
                            ]" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
