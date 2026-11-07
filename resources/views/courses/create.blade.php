<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Course</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('courses.store') }}">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <x-input-label for="code" value="Course Code" />
                            <x-text-input id="code" name="code" class="mt-1 block w-full" :value="old('code')" required />
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="title" value="Course Title" />
                            <x-text-input id="title" name="title" class="mt-1 block w-full" :value="old('title')" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" value="Description" />
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="credits" value="Credits" />
                                <x-text-input id="credits" type="number" name="credits" class="mt-1 block w-full" :value="old('credits', 3)" min="1" max="6" required />
                                <x-input-error :messages="$errors->get('credits')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="department" value="Department" />
                                <x-text-input id="department" name="department" class="mt-1 block w-full" :value="old('department')" />
                                <x-input-error :messages="$errors->get('department')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 gap-4">
                        <a href="{{ route('courses.index') }}" class="text-gray-600">Cancel</a>
                        <x-primary-button>Save Course</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>