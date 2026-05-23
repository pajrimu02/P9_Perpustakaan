<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Bookshelf') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 mb-6">

                <x-primary-button tag="a" href="{{ route('bookshelf.create') }}">
                    Tambah Bookshelf
                </x-primary-button>

            </div>

            <!-- Table -->
            <x-table>
                <x-slot name="header">
                    <tr class="text-left">
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Code</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </x-slot>

                @php $num = 1; @endphp

                @foreach($bookshelf as $item)
                <tr class="border-t dark:border-gray-700">
                    <td class="px-4 py-2">{{ $num++ }}</td>
                    <td class="px-4 py-2 font-semibold text-gray-800 dark:text-gray-200">
                        {{ $item->code }}
                    </td>
                    <td class="px-4 py-2 text-gray-600 dark:text-gray-300">
                        {{ $item->name }}
                    </td>

                    <td class="px-4 py-2 flex gap-2">

                        <!-- Edit -->
                        <x-primary-button tag="a"
                            href="{{ route('bookshelf.edit', $item->id) }}">
                            Edit
                        </x-primary-button>

                        <!-- Delete -->
                        <form action="{{ route('bookshelf.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <x-danger-button
                                onclick="return confirm('Yakin mau hapus bookshelf ini?')">
                                Hapus
                            </x-danger-button>
                        </form>

                    </td>
                </tr>
                @endforeach

            </x-table>

        </div>
    </div>
</x-app-layout>