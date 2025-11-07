<x-layout.default>
    <div class="panel">
        <!-- Header with Actions -->
        <div class="flex items-center justify-between mb-5">
            <h5 class="font-semibold text-lg dark:text-white-light">School Students</h5>
            <div class="flex items-center space-x-3">
                <a href="{{ route('sstudent.export', request()->query()) }}" class="btn btn-outline-success">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export CSV
                </a>
                <a href="{{ route('sstudent.create') }}" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Student
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Search Bar -->
        <div class="mb-5 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
            <form method="GET" action="{{ route('sstudent.index') }}" class="flex items-center space-x-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search students by name, mobile, email, or class..."
                           class="form-input w-full">
                </div>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('sstudent.index') }}" class="btn btn-outline-secondary">Clear</a>
                @endif
            </form>
        </div>

        <!-- Bulk Actions -->
        <div class="mb-4" id="bulkActions" style="display: none;">
            <form method="POST" action="{{ route('sstudent.bulk-delete') }}" onsubmit="return confirm('Are you sure you want to delete selected students?')">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete Selected (<span id="selectedCount">0</span>)
                </button>
            </form>
        </div>

        <!-- Students Table -->
        <div class="table-responsive">
            <table class="table-hover w-full">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll" class="form-checkbox">
                        </th>
                        <th>Student Name</th>
                        <th>Mobile</th>
                        <th>Class</th>
                        <th>Fees Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                  
                        @php
                            $totalClassFee = $student->class->fees ?? 0;
                            $paidAmount = $student->fees->sum('fees_submitted') + $student->fees->sum('extra_discount');
                            $remaining = max(0, $totalClassFee - $paidAmount);
                            $paymentProgress = $totalClassFee > 0 ? ($paidAmount / $totalClassFee) * 100 : 0;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td>
                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="form-checkbox student-checkbox">
                            </td>
                            <td>
                                <div class="flex items-center">
                                    @if($student->photo)
                                        <img class="w-8 h-8 rounded-full ltr:mr-2 rtl:ml-2 object-cover" 
                                             src="{{ Storage::url($student->photo) }}" alt="Photo">
                                    @else
                                        <div class="w-8 h-8 rounded-full ltr:mr-2 rtl:ml-2 bg-gray-300 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="font-semibold">{{ $student->name }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="text-sm">{{ $student->mobile ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="badge badge-outline-primary text-xs">{{ $student->class->c_name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="{{ $remaining > 0 ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $remaining > 0 ? 'Pending' : 'Paid' }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ number_format($paymentProgress, 0) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                    <div class="bg-gradient-to-r from-blue-500 to-green-500 h-1.5 rounded-full transition-all duration-300" 
                                         style="width: {{ min($paymentProgress, 100) }}%"></div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="flex justify-center space-x-1">
                                    <!-- View Details -->
                                    <a href="{{ route('sstudent.show', $student->id) }}" x-tooltip="View Details">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('sstudent.edit', $student->id) }}" x-tooltip="Edit">
                                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.586-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.414-8.414z"></path>
                                        </svg>
                                    </a>

                                    <!-- Pay Fees -->
                                    @if($remaining > 0)
                                        <button type="button" x-tooltip="Pay Fees" onclick="openFeesModal({{ $student->id }}, {{ $totalClassFee }}, {{ $paidAmount }})">
                                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v1H7v2h2v1c0 1.657 1.343 3 3 3s3-1.343 3-3h-2a1 1 0 01-2 0v-1h2v-2h-2v-1a1 1 0 012 0h2c0-1.657-1.343-3-3-3z"></path>
                                            </svg>
                                        </button>
                                    @endif

                                    <!-- Delete -->
                                    <form action="{{ route('sstudent.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" x-tooltip="Delete">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-8">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <div class="text-lg font-medium mb-2">No students found</div>
                                <div class="text-sm text-gray-400 mb-4">Try adjusting your search criteria or add a new student.</div>
                                <a href="{{ route('sstudent.create') }}" class="btn btn-primary">Add First Student</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>

    <!-- Fees Modal -->
    <div id="feesModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96 max-w-full mx-4">
            <h2 class="text-lg font-bold mb-4 dark:text-white">Submit Fees</h2>
            <form method="POST" action="{{ route('sstudent.store') }}">
                @csrf
                <input type="hidden" name="student_id" id="modal_student_id">
                <input type="hidden" id="total_fees" value="0">
                <input type="hidden" id="paid_amount" value="0">

                <div class="mb-3">
                    <label class="block font-medium dark:text-white">Already Paid</label>
                    <input type="text" id="fees_paid" class="form-input w-full bg-gray-100 dark:bg-gray-700" readonly>
                </div>

                <div class="mb-3">
                    <label class="block font-medium dark:text-white">Remaining Fees</label>
                    <input type="text" id="fees_remaining" class="form-input w-full bg-gray-100 dark:bg-gray-700" readonly>
                </div>

                <div class="mb-3">
                    <label class="block font-medium dark:text-white">Extra Discount</label>
                    <input type="number" step="0.01" name="extra_discount" id="extra_discount" class="form-input w-full" placeholder="0.00">
                </div>

                <div class="mb-3">
                    <label class="block font-medium dark:text-white">Fees Submitted *</label>
                    <input type="number" step="0.01" name="fees_submitted" id="fees_submitted" class="form-input w-full" required>
                </div>

                <div class="mb-3">
                    <label class="block font-medium dark:text-white">Date of Submission *</label>
                    <input type="date" name="date_of_submitted" class="form-input w-full" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" onclick="closeFeesModal()" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Bulk selection functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });

        document.querySelectorAll('.student-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const selectedCheckboxes = document.querySelectorAll('.student-checkbox:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            
            if (selectedCheckboxes.length > 0) {
                bulkActions.style.display = 'block';
                selectedCount.textContent = selectedCheckboxes.length;
                
                // Update form with selected IDs
                const form = bulkActions.querySelector('form');
                form.innerHTML = form.innerHTML.replace(/<input[^>]*name="student_ids\[\]"[^>]*>/g, '');
                
                selectedCheckboxes.forEach(checkbox => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'student_ids[]';
                    input.value = checkbox.value;
                    form.appendChild(input);
                });
            } else {
                bulkActions.style.display = 'none';
            }
        }

        // Fees modal functions
        function openFeesModal(studentId, totalFees, paidAmount) {
            document.getElementById('modal_student_id').value = studentId;
            document.getElementById('total_fees').value = totalFees;
            document.getElementById('paid_amount').value = paidAmount;

            let remaining = totalFees - paidAmount;
            document.getElementById('fees_paid').value = '₹' + paidAmount.toFixed(2);
            document.getElementById('fees_remaining').value = '₹' + remaining.toFixed(2);
            document.getElementById('fees_submitted').value = remaining.toFixed(2);
            document.getElementById('extra_discount').value = "";

            document.getElementById('feesModal').classList.remove('hidden');
        }

        function closeFeesModal() {
            document.getElementById('feesModal').classList.add('hidden');
        }

        document.getElementById('extra_discount').addEventListener('input', function () {
            let totalFees = parseFloat(document.getElementById('total_fees').value) || 0;
            let paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;
            let extra = parseFloat(this.value) || 0;

            let remaining = totalFees - paidAmount - extra;
            if (remaining < 0) remaining = 0;

            document.getElementById('fees_remaining').value = '₹' + remaining.toFixed(2);
            document.getElementById('fees_submitted').value = remaining.toFixed(2);
        });
    </script>
</x-layout.default>