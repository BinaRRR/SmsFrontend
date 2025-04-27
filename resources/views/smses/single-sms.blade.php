<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Recipients | Edit mode') }}
        </h2>
        <a href="{{ url()->previous() }}"">[GO BACK]</a>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-xl text-center">
                        {{ __('You are currently editing SMS: :name', ['name' => $sms['id']]) }}
                    </h1>
                    <div class="py-4">
                        <div>
                            {{-- {{dd($sms)}} --}}
                            <livewire:binar-object-info :properties="$sms" :excludeEditable="['actuallySent', 'archiveTime']" route="sms" />
                        </div>
                        {{-- <div class="flex justify-between items-center border-b border-gray-400 my-4 mt-12">
                            <p class="text-gray-400 uppercase font-mono font-bold" style="font-variant: small-caps">
                                {{ __('Group memberships') }}</p>
                            <button class="hover:bg-green-600 transition-colors text-white grid place-items-center">
                                <p class="uppercase px-2 py-2 font-bold">
                                    Save &nbsp; <i class="fa-solid fa-floppy-disk"></i>
                                </p>
                            </button>
                        </div> --}}
                        <div class="flex justify-between items-center border-b border-gray-400 my-4 mt-12">
                            <p class="text-gray-400 uppercase font-mono font-bold py-2"
                               style="font-variant: small-caps">
                                {{ __('Groups that will have this SMS delivered') }}</p>
                        </div>
                        <livewire:binar-table title="" :headers="$tableHeaders" :contents="$tableContents" route="recipient-group"
                            secondaryButtonIcon="fa-xmark" secondaryButtonAction="/remove-group"
                            secondaryButtonTitle="Deattach from this SMS" :parentEntityId="$sms['id']"
                            secondaryButtonRoute="sms"
                        />
                        <div class="flex justify-between items-center border-b border-gray-400 my-4 mt-12">
                            <p class="text-gray-400 uppercase font-mono font-bold py-2"
                               style="font-variant: small-caps">
                                {{ __('Groups that can be attached as recipients') }}</p>
                        </div>
                        <livewire:binar-table title="" :headers="$tableHeaders" :contents="$allRecipientGroups" route="recipient-group"
                                              secondaryButtonIcon="fa-plus" secondaryButtonAction="/add-group"
                                              secondaryButtonTitle="Attach to this SMS" secondaryButtonColor="text-green-500"
                                              :excludeContents="$tableContents" :parentEntityId="$sms['id']"
                                              secondaryButtonRoute="sms"
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
</x-app-layout>
