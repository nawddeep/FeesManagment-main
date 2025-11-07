<x-layout.default>
    <!-- Student Form -->
    <form class="space-y-5" method="POST" action="{{ route('sstudent.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Student Name -->
        <div>
            <label for="name">Student Name <span class="text-red-500">*</span></label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   class="form-input" 
                   placeholder="Enter student name" 
                   value="{{ old('name') }}"
                   required 
                   maxlength="255"
                   pattern="^[A-Za-z\s]+$"
                   title="Only letters and spaces are allowed" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Father Name -->
        <div>
            <label for="father_name">Father Name</label>
            <input type="text" 
                   name="father_name" 
                   id="father_name" 
                   class="form-input" 
                   placeholder="Enter father name" 
                   value="{{ old('father_name') }}"
                   maxlength="255"
                   pattern="^[A-Za-z\s]+$"
                   title="Only letters and spaces are allowed" />
            @error('father_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Mobile -->
        <div>
            <label for="mobile">Mobile <span class="text-red-500">*</span></label>
            <input type="text" 
                   name="mobile" 
                   id="mobile" 
                   class="form-input" 
                   placeholder="Enter mobile number" 
                   value="{{ old('mobile') }}"
                   required 
                   maxlength="15"
                   pattern="^[0-9]{10,15}$"
                   title="Enter a valid mobile number (10–15 digits)" />
            @error('mobile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email">Email</label>
            <input type="email" 
                   name="email" 
                   id="email" 
                   class="form-input" 
                   placeholder="name@example.com" 
                   value="{{ old('email') }}"
                   maxlength="255" />
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Gender (Radio buttons) -->
        <div>
            <label>Gender </label>
            <div class="flex space-x-4 mt-2">
                <label class="flex items-center">
                    <input type="radio" name="gender" value="male" class="form-radio" 
                           {{ old('gender', 'male') == 'male' ? 'checked' : '' }}>
                    <span class="ml-2">Male</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="gender" value="female" class="form-radio" 
                           {{ old('gender') == 'female' ? 'checked' : '' }}>
                    <span class="ml-2">Female</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="gender" value="tg" class="form-radio" 
                           {{ old('gender') == 'tg' ? 'checked' : '' }}>
                    <span class="ml-2">Transgender</span>
                </label>
            </div>
            @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Photo -->
        <div>
            <label for="photo">Photo</label>
            <input type="file" 
                   name="photo" 
                   id="photo"
                   class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0
                          file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white
                          file:hover:bg-primary"
                   accept=".jpg,.jpeg,.png" />
            @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Class Dropdown -->
        <div>
            <label for="class_id">Select Class <span class="text-red-500">*</span></label>
            <select name="class_id" id="class_id" class="form-select text-white-dark" required>
                <option value="">-- Select Class --</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->c_name }}
                    </option>
                @endforeach
            </select>
            @error('class_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary !mt-6">Submit</button>
    </form>
</x-layout.default>
