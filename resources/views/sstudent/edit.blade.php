<x-layout.default>
    <!-- Header with Back Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Edit Student</h2>
        <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Students
            </a>
    </div>

    <!-- Student Edit Form -->
    <form class="space-y-5" method="POST" action="{{ route('sstudent.update', $sstudent->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Student Name -->
        <div>
            <label for="name">Student Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" 
                   class="form-input" 
                   placeholder="Enter student name" 
                   value="{{ old('name', $sstudent->name) }}" 
                   required />
        </div>

        <!-- Father Name -->
        <div>
            <label for="father_name">Father Name</label>
            <input type="text" name="father_name" id="father_name" 
                   class="form-input" 
                   placeholder="Enter father name" 
                   value="{{ old('father_name', $sstudent->father_name) }}" />
        </div>

        <!-- Mobile -->
        <div>
            <label for="mobile">Mobile <span class="text-red-500">*</span></label>
            <input type="text" name="mobile" id="mobile" 
                   class="form-input" 
                   placeholder="Enter mobile number" 
                   value="{{ old('mobile', $sstudent->mobile) }}" 
                   required />
        </div>

        <!-- Email -->
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" 
                   class="form-input" 
                   placeholder="name@example.com" 
                   value="{{ old('email', $sstudent->email) }}" />
        </div>

        <!-- Gender (Radio buttons) -->
        <div>
            <label>Gender <span class="text-red-500">*</span></label>
            <div class="flex space-x-4 mt-2">
                <label class="flex items-center">
                    <input type="radio" name="gender" value="male" class="form-radio"
                           {{ old('gender', $sstudent->gender) === 'male' ? 'checked' : '' }}>
                    <span class="ml-2">Male</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="gender" value="female" class="form-radio"
                           {{ old('gender', $sstudent->gender) === 'female' ? 'checked' : '' }}>
                    <span class="ml-2">Female</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="gender" value="tg" class="form-radio"
                           {{ old('gender', $sstudent->gender) === 'tg' ? 'checked' : '' }}>
                    <span class="ml-2">Transgender</span>
                </label>
            </div>
        </div>

        <!-- Photo -->
        <div>
            <label for="photo">Photo</label>
            <input type="file" name="photo" id="photo"
                class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0
                       file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white
                       file:hover:bg-primary"/>

            @if($sstudent->photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/'.$sstudent->photo) }}" alt="Student Photo" class="h-16 rounded-md border">
                </div>
            @endif
        </div>

        <!-- Class Dropdown -->
        <div>
            <label for="class_id">Select Class <span class="text-red-500">*</span></label>
            <select name="class_id" id="class_id" class="form-select text-white-dark" required>
                <option value="">-- Select Class --</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ old('class_id', $sstudent->class_id) == $class->id ? 'selected' : '' }}>
                        {{ $class->c_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary !mt-6">Update</button>
    </form>
</x-layout.default>
