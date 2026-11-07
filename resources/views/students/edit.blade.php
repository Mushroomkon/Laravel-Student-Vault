<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Student</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('students.update', $student) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" value="Full Name (for login)" />
                            <x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name', $student->user->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" type="email" name="email" class="mt-1 block w-full" :value="old('email', $student->user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="student_number" value="Student Number" />
                            <x-text-input id="student_number" name="student_number" class="mt-1 block w-full" :value="old('student_number', $student->student_number)" required />
                            <x-input-error :messages="$errors->get('student_number')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="first_name" value="First Name" />
                            <x-text-input id="first_name" name="first_name" class="mt-1 block w-full" :value="old('first_name', $student->first_name)" required />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="last_name" value="Last Name" />
                            <x-text-input id="last_name" name="last_name" class="mt-1 block w-full" :value="old('last_name', $student->last_name)" required />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone" value="Phone" />
                            <x-text-input id="phone" name="phone" class="mt-1 block w-full" :value="old('phone', $student->phone)" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="date_of_birth" value="Date of Birth" />
                            <x-text-input id="date_of_birth" type="date" name="date_of_birth" class="mt-1 block w-full" 
                                          :value="old('date_of_birth', $student->date_of_birth?->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" value="Status" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="active" @selected(old('status', $student->status) == 'active')>Active</option>
                                <option value="inactive" @selected(old('status', $student->status) == 'inactive')>Inactive</option>
                                <option value="graduated" @selected(old('status', $student->status) == 'graduated')>Graduated</option>
                                <option value="suspended" @selected(old('status', $student->status) == 'suspended')>Suspended</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="address" value="Address" />
                            <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('address', $student->address) }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 gap-4">
                        <a href="{{ route('students.index') }}" class="text-gray-600">Cancel</a>
                        <x-primary-button>Update Student</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>