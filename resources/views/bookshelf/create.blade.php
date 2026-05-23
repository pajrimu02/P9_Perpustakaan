<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Bookshelf') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('bookshelf.store') }}" class="mt-6 space-y-6">
                    @csrf

                    <!-- Code -->
                    <div class="max-w-xl">
                        <x-input-label for="code" value="Kode Rak" />
                        <x-text-input
                            id="code"
                            type="text"
                            name="code"
                            class="mt-1 block w-full"
                            value="{{ old('code') }}"
                            required
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('code')" />
                    </div>

                    <!-- Name -->
                    <div class="max-w-xl">
                        <x-input-label for="name" value="Nama Rak Buku" />
                        <x-text-input
                            id="name"
                            type="text"
                            name="name"
                            class="mt-1 block w-full"
                            value="{{ old('name') }}"
                            required
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center gap-4">

                        <x-secondary-button tag="a" href="{{ route('bookshelf.index') }}">
                            Cancel
                        </x-secondary-button>

                        <x-primary-button>
                            Save
                        </x-primary-button>

                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>