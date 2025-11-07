<x-layout.default>
    <!-- Class Form -->
    <form class="space-y-5" method="POST" action="{{ route('sclass.store') }}">
        @csrf

        <!-- Class Name -->
        <div>
            <label for="c_name">Class Name <span class="text-red-500">*</span></label>
            <input type="text" name="c_name" id="c_name" class="form-input" placeholder="Enter class name" required />
        </div>

        <!-- Fees -->
        <div>
            <label for="fees">Fees</label>
            <input type="number" step="0.01" name="fees" id="fees" class="form-input" placeholder="Enter class fees" />
        </div>

        <!-- Discount -->
        <div>
            <label for="discount">Discount (%)</label>
            <input type="number" step="0.01" name="discount" id="discount" class="form-input" placeholder="Enter discount %" />
        </div>

        <!-- Status -->
        <div>
            <label>Status <span class="text-red-500">*</span></label>
            <div class="flex space-x-4 mt-2">
                <label class="flex items-center">
                    <input type="radio" name="status" value="1" class="form-radio" checked>
                    <span class="ml-2">Active</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="status" value="0" class="form-radio">
                    <span class="ml-2">Inactive</span>
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary !mt-6">Submit</button>
    </form>
</x-layout.default>
