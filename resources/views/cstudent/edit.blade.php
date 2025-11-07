<x-layout.default>
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h5 class="font-semibold text-lg dark:text-white-light">Edit Competition Student</h5>
            <a href="{{ route('cstudent.index') }}" class="btn btn-outline-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Students
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Student Form -->
        <form class="space-y-5" method="POST" action="{{ route('cstudent.update', $cstudent->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Student Name -->
            <div>
                <label for="name">Student Name <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       class="form-input" 
                       placeholder="Enter student name" 
                       value="{{ old('name', $cstudent->name) }}"
                       required 
                       maxlength="255"
                       pattern="^[A-Za-z\s]+$"
                       title="Only letters and spaces are allowed" />
            </div>

            <!-- Father Name -->
            <div>
                <label for="father_name">Father Name</label>
                <input type="text" 
                       name="father_name" 
                       id="father_name" 
                       class="form-input" 
                       placeholder="Enter father name" 
                       value="{{ old('father_name', $cstudent->father_name) }}"
                       maxlength="255"
                       pattern="^[A-Za-z\s]+$"
                       title="Only letters and spaces are allowed" />
            </div>

            <!-- Mobile -->
            <div>
                <label for="mobile">Mobile</label>
                <input type="text" 
                       name="mobile" 
                       id="mobile" 
                       class="form-input" 
                       placeholder="Enter mobile number" 
                       value="{{ old('mobile', $cstudent->mobile) }}"
                       maxlength="15"
                       pattern="^[0-9]{10,15}$"
                       title="Enter a valid mobile number (10–15 digits)" />
            </div>

            <!-- Email -->
            <div>
                <label for="email">Email</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       class="form-input" 
                       placeholder="name@example.com" 
                       value="{{ old('email', $cstudent->email) }}"
                       maxlength="255" />
            </div>

            <!-- Gender -->
            <div>
                <label>Gender <span class="text-red-500">*</span></label>
                <div class="flex space-x-4 mt-2">
                    <label class="flex items-center">
                        <input type="radio" name="gender" value="male" class="form-radio" 
                               {{ old('gender', $cstudent->gender) == 'male' ? 'checked' : '' }}>
                        <span class="ml-2">Male</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="gender" value="female" class="form-radio" 
                               {{ old('gender', $cstudent->gender) == 'female' ? 'checked' : '' }}>
                        <span class="ml-2">Female</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="gender" value="tg" class="form-radio" 
                               {{ old('gender', $cstudent->gender) == 'tg' ? 'checked' : '' }}>
                        <span class="ml-2">Transgender</span>
                    </label>
                </div>
            </div>

            <!-- Current Photo Display -->
            @if($cstudent->photo)
                <div>
                    <label>Current Photo</label>
                    <div class="mt-2">
                        <img src="{{ Storage::url($cstudent->photo) }}" alt="Current Photo" class="w-20 h-20 rounded-lg object-cover">
                    </div>
                </div>
            @endif

            <!-- Photo -->
            <div>
                <label for="photo">Change Photo</label>
                <input type="file" 
                       name="photo" 
                       id="photo"
                       class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0
                              file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white
                              file:hover:bg-primary"
                       accept=".jpg,.jpeg,.png" />
            </div>

            <!-- Address -->
            <div>
                <label for="address">Address</label>
                <textarea name="address" 
                          id="address" 
                          class="form-textarea" 
                          placeholder="Enter student address" 
                          rows="3">{{ old('address', $cstudent->address) }}</textarea>
            </div>

            <!-- Competition Level -->
            <div>
                <label for="competition_level">Competition Level</label>
                <select name="competition_level" id="competition_level" class="form-select">
                    <option value="">-- Select Competition Level --</option>
                    <option value="District" {{ old('competition_level', $cstudent->competition_level) == 'District' ? 'selected' : '' }}>District</option>
                    <option value="State" {{ old('competition_level', $cstudent->competition_level) == 'State' ? 'selected' : '' }}>State</option>
                    <option value="National" {{ old('competition_level', $cstudent->competition_level) == 'National' ? 'selected' : '' }}>National</option>
                    <option value="International" {{ old('competition_level', $cstudent->competition_level) == 'International' ? 'selected' : '' }}>International</option>
                </select>
            </div>

            <!-- Subjects Selection -->
            <div>
                <label>Select Subjects <span class="text-red-500">*</span></label>
                <div class="mt-2 border border-gray-300 rounded-lg p-4 max-h-60 overflow-y-auto">
                    @forelse($ssubjects as $subject)
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                            <input type="checkbox" 
                                   name="ssubjects[]" 
                                   value="{{ $subject->id }}" 
                                   class="form-checkbox mr-3"
                                   {{ in_array($subject->id, old('ssubjects', $selectedSubjects)) ? 'checked' : '' }}>
                            <div class="flex-1">
                                <div class="font-medium">{{ $subject->subject_name }}</div>
                                <div class="text-sm text-gray-500">
                                    Fees: ₹{{ number_format($subject->fees ?? 0, 2) }}
                                    @if($subject->discount)
                                        | Discount: {{ $subject->discount }}%
                                    @endif
                                </div>
                                @php
                                    $enrollment = $cstudent->enrollments()->where('ssubject_id', $subject->id)->first();
                                @endphp
                                @if($enrollment)
                                    <div class="text-xs text-blue-600">
                                        Status: {{ ucfirst($enrollment->status) }} | 
                                        Paid: ₹{{ number_format($enrollment->fees_paid, 2) }}
                                    </div>
                                @endif
                            </div>
                        </label>
                    @empty
                        <p class="text-gray-500 text-center py-4">No subjects available. Please add subjects first.</p>
                    @endforelse
                </div>
                @error('ssubjects')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('cstudent.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    Update Student
                </button>
            </div>
        </form>
    </div>

    <script>
        // Add some interactivity to subject selection
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="ssubjects[]"]');
            
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const selectedCount = document.querySelectorAll('input[name="ssubjects[]"]:checked').length;
                    console.log('Selected subjects:', selectedCount);
                });
            });
        });
    </script>
</x-layout.default>