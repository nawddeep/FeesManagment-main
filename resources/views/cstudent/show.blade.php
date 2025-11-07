<x-layout.default>
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h5 class="font-semibold text-lg dark:text-white-light">Competition Student Details</h5>
            <div class="flex items-center space-x-3">
                <a href="{{ route('cstudent.index') }}" class="btn btn-outline-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
                <a href="{{ route('cstudent.edit', $cstudent->id) }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.586-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.414-8.414z"></path>
                    </svg>
                    Edit Student
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Student Information -->
            <div class="lg:col-span-2">
                <div class="panel">
                    <div class="flex items-center mb-5">
                        <h6 class="font-semibold text-lg dark:text-white-light">Personal Information</h6>
                    </div>
                    
                    <div class="flex items-start space-x-6">
                        <!-- Student Photo -->
                        <div class="flex-shrink-0">
                            @if($cstudent->photo)
                                <img src="{{ Storage::url($cstudent->photo) }}" alt="Student Photo" class="w-32 h-32 rounded-lg object-cover border-4 border-white shadow-lg">
                            @else
                                <div class="w-32 h-32 rounded-lg bg-gray-300 flex items-center justify-center border-4 border-white shadow-lg">
                                    <svg class="w-16 h-16 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Student Details -->
                        <div class="flex-1">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</label>
                                    <p class="text-lg font-semibold dark:text-white">{{ $cstudent->name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Father's Name</label>
                                    <p class="text-lg dark:text-white">{{ $cstudent->father_name ?? 'Not provided' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Mobile Number</label>
                                    <p class="text-lg dark:text-white flex items-center">
                                        @if($cstudent->mobile)
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            {{ $cstudent->mobile }}
                                        @else
                                            <span class="text-gray-400">Not provided</span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email Address</label>
                                    <p class="text-lg dark:text-white flex items-center">
                                        @if($cstudent->email)
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $cstudent->email }}
                                        @else
                                            <span class="text-gray-400">Not provided</span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Gender</label>
                                    <p class="text-lg dark:text-white">
                                        <span class="badge badge-outline-primary">{{ ucfirst($cstudent->gender ?? 'male') }}</span>
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Competition Level</label>
                                    <p class="text-lg dark:text-white">
                                        <span class="badge badge-outline-success">{{ ucfirst($cstudent->competition_level) }}</span>
                                    </p>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Enrollment Date</label>
                                    <p class="text-lg dark:text-white">{{ $cstudent->created_at->format('d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subjects Information -->
                <div class="panel mt-6">
                    <h6 class="font-semibold text-lg dark:text-white-light mb-4">Enrolled Subjects</h6>
                    @if($cstudent->ssubjects->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($cstudent->ssubjects as $subject)
                                @php
                                    $feesSubmitted = $subject->pivot->fees_submitted ?? 0;
                                    $feesPaid = $subject->pivot->fees_paid ?? 0;
                                    $extraDiscount = $subject->pivot->extra_discount ?? 0;
                                    $subjectPaid = max($feesSubmitted, $feesPaid) + $extraDiscount;
                                    $subjectRemaining = max(0, $subject->fees - $subjectPaid);
                                    $subjectProgress = $subject->fees > 0 ? ($subjectPaid / $subject->fees) * 100 : 0;
                                @endphp
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <h7 class="font-semibold dark:text-white">{{ $subject->s_name }}</h7>
                                        <span class="badge badge-outline-primary">{{ ucfirst($subject->status ? 'Active' : 'Inactive') }}</span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $subject->description ?? 'No description available' }}</p>
                                    
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600 dark:text-gray-400">Fees Progress</span>
                                            <span class="font-medium">{{ number_format($subjectProgress, 0) }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-2 rounded-full transition-all duration-300" 
                                                 style="width: {{ min($subjectProgress, 100) }}%"></div>
                                        </div>
                                        <div class="flex justify-between text-xs">
                                            <span>₹{{ number_format($subjectPaid, 2) }} / ₹{{ number_format($subject->fees, 2) }}</span>
                                            @if($subjectRemaining > 0)
                                                <span class="text-red-600">₹{{ number_format($subjectRemaining, 2) }} remaining</span>
                                            @else
                                                <span class="text-green-600 font-medium">Fully Paid</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No subjects enrolled yet.</p>
                    @endif
                </div>
            </div>

            <!-- Fees Summary -->
            <div class="lg:col-span-1">
                <div class="panel">
                    <h6 class="font-semibold text-lg dark:text-white-light mb-4">Fees Summary</h6>
                    
                    @php
                        $totalFees = $cstudent->ssubjects->sum('fees');
                        $totalPaid = $cstudent->ssubjects->sum(function ($subject) {
                            $feesSubmitted = $subject->pivot->fees_submitted ?? 0;
                            $feesPaid = $subject->pivot->fees_paid ?? 0;
                            $extraDiscount = $subject->pivot->extra_discount ?? 0;
                            return max($feesSubmitted, $feesPaid) + $extraDiscount;
                        });
                        $remaining = max(0, $totalFees - $totalPaid);
                        $overallProgress = $totalFees > 0 ? ($totalPaid / $totalFees) * 100 : 0;
                    @endphp

                    <!-- Overall Fee Progress -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium dark:text-white">Overall Payment Progress</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($overallProgress, 0) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 dark:bg-gray-700">
                            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ min($overallProgress, 100) }}%"></div>
                        </div>
                    </div>

                    <!-- Fee Summary -->
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Total Fees:</span>
                            <span class="font-semibold dark:text-white">₹{{ number_format($totalFees, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Amount Paid:</span>
                            <span class="font-semibold text-green-600 dark:text-green-400">₹{{ number_format($totalPaid, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Remaining:</span>
                            <span class="font-semibold {{ $remaining > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                ₹{{ number_format($remaining, 2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6 space-y-2">
                        @if($remaining > 0)
                            <button type="button" onclick="openFeesModal({{ $cstudent->id }})" 
                                    class="btn btn-primary w-full">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v1H7v2h2v1c0 1.657 1.343 3 3 3s3-1.343 3-3h-2a1 1 0 01-2 0v-1h2v-2h-2v-1a1 1 0 012 0h2c0-1.657-1.343-3-3-3z"></path>
                                </svg>
                                Pay Fees
                            </button>
                        @else
                            <div class="btn btn-success w-full cursor-not-allowed">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Fully Paid
                            </div>
                        @endif
                        
                        <button type="button" onclick="openHistoryModal({{ $cstudent->id }})"
                                class="btn btn-outline-secondary w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            View History
                        </button>

                        <a href="{{ route('cstudent.receipt', $cstudent->id) }}" target="_blank"
                           class="btn btn-outline-info w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-4a2 2 0 012-2h2m2 4h10a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2h2"></path>
                            </svg>
                            Print Receipt
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="panel mt-6">
                    <h6 class="font-semibold text-lg dark:text-white-light mb-4">Recent Activity</h6>
                    <div class="space-y-3">
                        @forelse($cstudent->ssubjects->take(3) as $subject)
                            @php
                                $pivotData = $subject->pivot;
                                $lastPayment = $pivotData->date_of_submitted ?? null;
                            @endphp
                            @php
                                $feesSubmitted = $pivotData->fees_submitted ?? 0;
                                $feesPaid = $pivotData->fees_paid ?? 0;
                                $totalPaidAmount = max($feesSubmitted, $feesPaid);
                            @endphp
                            @if($lastPayment && $totalPaidAmount > 0)
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v1H7v2h2v1c0 1.657 1.343 3 3 3s3-1.343 3-3h-2a1 1 0 01-2 0v-1h2v-2h-2v-1a1 1 0 012 0h2c0-1.657-1.343-3-3-3z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium dark:text-white">Fee Payment - {{ $subject->s_name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            ₹{{ number_format($totalPaidAmount, 2) }} on {{ \Carbon\Carbon::parse($lastPayment)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent activity</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fees Modal -->
    <div id="feesModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96 max-w-full mx-4">
            <h2 class="text-lg font-bold mb-4 dark:text-white">Submit Fees</h2>
            <form method="POST" action="{{ route('cstudent.store') }}">
                @csrf
                <input type="hidden" name="cstudent_id" id="modal_cstudent_id">
                <input type="hidden" name="ssubject_id" id="modal_ssubject_id">
                <input type="hidden" id="total_subject_fees" value="0">
                <input type="hidden" id="paid_amount_subject" value="0">

                <div class="mb-3">
                    <label class="block font-medium dark:text-white">Subject</label>
                    <select name="ssubject_id" id="subject_select" class="form-select w-full" required>
                        <option value="">Select Subject</option>
                        @foreach($cstudent->ssubjects as $subject)
                            @php
                                $feesSubmitted = $subject->pivot->fees_submitted ?? 0;
                                $feesPaid = $subject->pivot->fees_paid ?? 0;
                                $extraDiscount = $subject->pivot->extra_discount ?? 0;
                                $subjectPaid = max($feesSubmitted, $feesPaid) + $extraDiscount;
                                $subjectRemaining = max(0, $subject->fees - $subjectPaid);
                            @endphp
                            @if($subjectRemaining > 0)
                                <option value="{{ $subject->id }}" data-fees="{{ $subject->fees }}" data-paid="{{ $subjectPaid }}">
                                    {{ $subject->s_name }} (₹{{ number_format($subjectRemaining, 2) }} remaining)
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block font-medium dark:text-white">Already Paid</label>
                    <input type="text" id="fees_paid_subject" class="form-input w-full bg-gray-100 dark:bg-gray-700" readonly>
                </div>

                <div class="mb-3">
                    <label class="block font-medium dark:text-white">Remaining Fees</label>
                    <input type="text" id="fees_remaining_subject" class="form-input w-full bg-gray-100 dark:bg-gray-700" readonly>
                </div>

                <div class="mb-3">
                    <label class="block font-medium dark:text-white">Extra Discount</label>
                    <input type="number" step="0.01" name="extra_discount_pivot" id="extra_discount_pivot" class="form-input w-full" placeholder="0.00">
                </div>

                <div class="mb-3">
                    <label class="block font-medium dark:text-white">Fees Submitted *</label>
                    <input type="number" step="0.01" name="fees_submitted_pivot" id="fees_submitted_pivot" class="form-input w-full" required>
                </div>

                <div class="mb-3">
                    <label class="block font-medium dark:text-white">Date of Submission *</label>
                    <input type="date" name="date_of_submitted_pivot" class="form-input w-full" value="{{ date('Y-m-d') }}" required>
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

    <!-- Fees History Modal -->
    <div id="historyModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-2/3 max-w-4xl max-h-[80vh] mx-4">
            <h2 class="text-lg font-bold mb-4 dark:text-white">Complete Fees History</h2>
            <div id="historyContent" class="max-h-96 overflow-y-auto">
                @if($cstudent->ssubjects->count())
                    @foreach($cstudent->ssubjects as $subject)
                        @php
                            $pivotRecords = \App\Models\CstudentSsubject::where('cstudent_id', $cstudent->id)
                                                                        ->where('ssubject_id', $subject->id)
                                                                        ->get();
                            $totalSubjectFee = $subject->fees ?? 0;
                        @endphp
                        @if($pivotRecords->count())
                            <h4 class="font-semibold mt-4 mb-2 dark:text-white">Subject: {{ $subject->s_name }} (Total Fees: ₹{{ number_format($totalSubjectFee, 2) }})</h4>
                            <div class="overflow-x-auto mb-4">
                                <table class="w-full table-auto border-collapse border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <th class="border border-gray-300 px-4 py-2 dark:text-white">Date</th>
                                            <th class="border border-gray-300 px-4 py-2 dark:text-white">Fees Submitted</th>
                                            <th class="border border-gray-300 px-4 py-2 dark:text-white">Extra Discount</th>
                                            <th class="border border-gray-300 px-4 py-2 dark:text-white">Remaining</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $remainingLoop = $totalSubjectFee; @endphp
                                        @foreach ($pivotRecords->sortBy('date_of_submitted') as $pivot)
                                            @php
                                                $feesSubmitted = $pivot->fees_submitted ?? 0;
                                                $feesPaid = $pivot->fees_paid ?? 0;
                                                $totalPayment = max($feesSubmitted, $feesPaid) + ($pivot->extra_discount ?? 0);
                                                $remainingLoop -= $totalPayment;
                                            @endphp
                                            <tr>
                                                <td class="border border-gray-300 px-4 py-2 dark:text-white">{{ \Carbon\Carbon::parse($pivot->date_of_submitted)->format('d/m/Y') }}</td>
                                                <td class="border border-gray-300 px-4 py-2 dark:text-white">₹{{ number_format(max($feesSubmitted, $feesPaid), 2) }}</td>
                                                <td class="border border-gray-300 px-4 py-2 dark:text-white">
                                                    {{ $pivot->extra_discount ? '₹' . number_format($pivot->extra_discount, 2) : '—' }}
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2 dark:text-white">₹{{ number_format(max($remainingLoop,0),2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center text-gray-500 dark:text-gray-400">No fees history found for {{ $subject->s_name }}.</p>
                        @endif
                    @endforeach
                @else
                    <p class="text-center text-gray-500 dark:text-gray-400">No subjects enrolled for this student.</p>
                @endif
            </div>
            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeHistoryModal()" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        function openFeesModal(cstudentId) {
            document.getElementById('modal_cstudent_id').value = cstudentId;
            document.getElementById('feesModal').classList.remove('hidden');
            updateSubjectDetails();
        }

        function closeFeesModal() {
            document.getElementById('feesModal').classList.add('hidden');
        }

        function updateSubjectDetails() {
            const subjectSelect = document.getElementById('subject_select');
            const selectedOption = subjectSelect.options[subjectSelect.selectedIndex];
            
            if (selectedOption.value) {
                const totalFees = parseFloat(selectedOption.dataset.fees) || 0;
                const paidAmount = parseFloat(selectedOption.dataset.paid) || 0;
                const remaining = totalFees - paidAmount;

                document.getElementById('total_subject_fees').value = totalFees;
                document.getElementById('paid_amount_subject').value = paidAmount;
                document.getElementById('fees_paid_subject').value = '₹' + paidAmount.toFixed(2);
                document.getElementById('fees_remaining_subject').value = '₹' + remaining.toFixed(2);
                document.getElementById('fees_submitted_pivot').value = remaining.toFixed(2);
                document.getElementById('extra_discount_pivot').value = "";
            }
        }

        document.getElementById('subject_select').addEventListener('change', updateSubjectDetails);

        document.getElementById('extra_discount_pivot').addEventListener('input', function () {
            let totalFees = parseFloat(document.getElementById('total_subject_fees').value) || 0;
            let paidAmount = parseFloat(document.getElementById('paid_amount_subject').value) || 0;
            let extra = parseFloat(this.value) || 0;

            let remaining = totalFees - paidAmount - extra;
            if (remaining < 0) remaining = 0;

            document.getElementById('fees_remaining_subject').value = '₹' + remaining.toFixed(2);
            document.getElementById('fees_submitted_pivot').value = remaining.toFixed(2);
        });

        function openHistoryModal(cstudentId) {
            document.getElementById('historyModal').classList.remove('hidden');
        }

        function closeHistoryModal() {
            document.getElementById('historyModal').classList.add('hidden');
        }
    </script>
</x-layout.default>
