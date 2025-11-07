<x-layout.default>
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h5 class="font-semibold text-lg dark:text-white-light">Edit Competition Subject</h5>
            <a href="{{url()->previous() }}" class="btn btn-outline-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Subjects
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

        <!-- Subject Form -->
        <form class="space-y-5" method="POST" action="{{ route('ssubject.update', $ssubject->id) }}">
            @csrf
            @method('PUT')

            <!-- Subject Name -->
            <div>
                <label for="subject_name">Subject Name <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="subject_name" 
                       id="subject_name" 
                       class="form-input" 
                       placeholder="Enter subject name" 
                       value="{{ old('subject_name', $ssubject->subject_name) }}"
                       required 
                       maxlength="255" />
            </div>

            <!-- Fees -->
            <div>
                <label for="fees">Fees</label>
                <input type="number" 
                       step="0.01" 
                       name="fees" 
                       id="fees" 
                       class="form-input" 
                       placeholder="Enter subject fees" 
                       value="{{ old('fees', $ssubject->fees) }}" />
            </div>

            <!-- Discount -->
            <div>
                <label for="discount">Discount (%)</label>
                <input type="number" 
                       step="0.01" 
                       name="discount" 
                       id="discount" 
                       class="form-input" 
                       placeholder="Enter discount percentage" 
                       value="{{ old('discount', $ssubject->discount) }}" 
                       min="0" 
                       max="100" />
            </div>

            <!-- Description -->
            <div>
                <label for="description">Description</label>
                <textarea name="description" 
                          id="description" 
                          class="form-textarea" 
                          placeholder="Enter subject description" 
                          rows="4">{{ old('description', $ssubject->description) }}</textarea>
            </div>

            <!-- Status -->
            <div>
                <label>Status <span class="text-red-500">*</span></label>
                <div class="flex space-x-4 mt-2">
                    <label class="flex items-center">
                        <input type="radio" 
                               name="status" 
                               value="1" 
                               class="form-radio" 
                               {{ old('status', $ssubject->status) == '1' ? 'checked' : '' }}>
                        <span class="ml-2">Active</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" 
                               name="status" 
                               value="0" 
                               class="form-radio" 
                               {{ old('status', $ssubject->status) == '0' ? 'checked' : '' }}>
                        <span class="ml-2">Inactive</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('ssubject.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    Update Subject
                </button>
            </div>
        </form>
    </div>
</x-layout.default>