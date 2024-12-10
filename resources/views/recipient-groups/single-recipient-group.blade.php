<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Recipient groups | Edit mode') }}
        </h2>
        <a href="{{ url()->previous() }}">[GO BACK]</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-xl text-center">
                        {{ __('You are currently editing recipient group: :name', ['name' => $recipientGroup['name']]) }}
                    </h1>
                    <div class="py-4">
                        <div>
                            <livewire:binar-object-info :properties="$recipientGroup" route="recipient-group" />
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-400 my-4 mt-12">
                            <p class="text-gray-400 uppercase font-mono font-bold py-2"
                               style="font-variant: small-caps">
                                {{ __('Recipients in this group') }}</p>
                        </div>
                        <livewire:binar-table title="" :headers="$tableHeaders" :contents="$tableContents" route="recipient"
                            secondaryButtonIcon="fa-xmark" secondaryButtonAction="/remove-recipient"
                            secondaryButtonTitle="Exit group" :parentEntityId="$recipientGroup['id']"
                            secondaryButtonRoute="recipient-group"
                        />
                        <div class="flex justify-between items-center border-b border-gray-400 my-4 mt-12">
                            <p class="text-gray-400 uppercase font-mono font-bold py-2"
                               style="font-variant: small-caps">
                                {{ __('Recipients you can add') }}</p>
                        </div>
                        <livewire:binar-table title="" :headers="$secondTableHeaders" :contents="$allRecipients" route="recipient"
                                              secondaryButtonIcon="fa-plus" secondaryButtonAction="/add-recipient"
                                              secondaryButtonTitle="Add to group" secondaryButtonColor="text-green-500"
                                              :excludeContents="$tableContents" :parentEntityId="$recipientGroup['id']"
                                              secondaryButtonRoute="recipient-group"
                        />
                        <div class="flex justify-between items-center border-b border-gray-400 my-4 mt-12">
                            <p class="text-gray-400 uppercase font-mono font-bold py-2"
                                style="font-variant: small-caps">
                                {{ __('Actions') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
