<x-layout.default>
    <!-- Edit Class Form -->
    <form class="space-y-5" method="POST" action="{{ route('sclass.update', $sclass->id) }}">
        @csrf
        @method('PUT')

        <!-- Class Name -->
        <div>
            <label for="c_name">Class Name <span class="text-red-500">*</span></label>
            <input 
                type="text" 
                name="c_name" 
                id="c_name" 
                class="form-input" 
                value="{{ old('c_name', $sclass->c_name) }}" 
                placeholder="Enter class name" 
                required 
            />
        </div>

        <!-- Fees -->
        <div>
            <label for="fees">Fees</label>
            <input 
                type="number" 
                step="0.01" 
                name="fees" 
                id="fees" 
                class="form-input" 
                value="{{ old('fees', $sclass->fees) }}" 
                placeholder="Enter class fees" 
            />
        </div>

        <!-- Discount -->
        <div>
            <label for="discount">Discount (%)</label>
            <input 
                type="number" 
                step="0.01" 
                name="discount" 
                id="discount" 
                class="form-input" 
                value="{{ old('discount', $sclass->discount) }}" 
                placeholder="Enter discount %" 
            />
        </div>

        <!-- Status -->
        <div>
            <label>Status <span class="text-red-500">*</span></label>
            <div class="flex space-x-4 mt-2">
                <label class="flex items-center">
                    <input 
                        type="radio" 
                        name="status" 
                        value="1" 
                        class="form-radio" 
                        {{ old('status', $sclass->status) == 1 ? 'checked' : '' }}>
                    <span class="ml-2">Active</span>
                </label>
                <label class="flex items-center">
                    <input 
                        type="radio" 
                        name="status" 
                        value="0" 
                        class="form-radio" 
                        {{ old('status', $sclass->status) == 0 ? 'checked' : '' }}>
                    <span class="ml-2">Inactive</span>
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary !mt-6">Update</button>
    </form>
</x-layout.default>
