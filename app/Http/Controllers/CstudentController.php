<?php

namespace App\Http\Controllers;

use App\Models\Cstudent;
use App\Models\Ssubject;
use App\Models\CstudentSsubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CstudentController extends Controller
{
    /**
     * Display a listing of the competition students.
     */
    public function index(Request $request)
    {
        $query = Cstudent::with(['ssubjects']);

        // Simple search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('father_name', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('ssubjects', function ($subjectQuery) use ($search) {
                      $subjectQuery->where('subject_name', 'like', "%{$search}%");
                  });
            });
        }

        $cstudents = $query->latest()->paginate(15)->withQueryString();

        return view('cstudent.index', compact('cstudents'));
    }

    /**
     * Show the form for creating a new competition student.
     */
    public function create()
    {
        $ssubjects = Ssubject::where('status', 1)->get();
        return view('cstudent.create', compact('ssubjects'));
    }

    /**
     * Store a newly created competition student.
     */
    public function store(Request $request)
    {
        // Handle fee submission for an existing student
        if ($request->has('cstudent_id') && $request->has('fees_submitted_pivot')) {
            $request->validate([
                'cstudent_id'          => 'required|exists:cstudents,id',
                'fees_submitted_pivot' => 'required|numeric|min:0',
                'extra_discount_pivot' => 'nullable|numeric|min:0',
                'date_of_submitted_pivot' => 'required|date',
            ]);

            $cstudent = Cstudent::with('ssubjects')->findOrFail($request->cstudent_id);
            
            // Calculate total fees and already paid amount across all subjects
            $totalFees = $cstudent->ssubjects->sum('fees');
            $totalPaid = $cstudent->ssubjects->sum(function ($subject) {
                $feesSubmitted = $subject->pivot->fees_submitted ?? 0;
                $feesPaid = $subject->pivot->fees_paid ?? 0;
                $extraDiscount = $subject->pivot->extra_discount ?? 0;
                return max($feesSubmitted, $feesPaid) + $extraDiscount;
            });

            $remaining = $totalFees - $totalPaid;
            $feesToSubmit = $request->fees_submitted_pivot;
            $extraDiscount = $request->extra_discount_pivot ?? 0;

            if (($feesToSubmit + $extraDiscount) > $remaining) {
                return redirect()->back()->withErrors(['fees_submitted_pivot' => "Cannot submit more than remaining fees (₹" . number_format($remaining, 2) . ")."]);
            }

            // Distribute the payment across all subjects proportionally
            $totalToDistribute = $feesToSubmit + $extraDiscount;
            $remainingFeesPerSubject = [];

            foreach ($cstudent->ssubjects as $subject) {
                $feesSubmitted = $subject->pivot->fees_submitted ?? 0;
                $feesPaid = $subject->pivot->fees_paid ?? 0;
                $extraDiscount = $subject->pivot->extra_discount ?? 0;
                $subjectPaid = max($feesSubmitted, $feesPaid) + $extraDiscount;
                $subjectRemaining = max(0, $subject->fees - $subjectPaid);
                $remainingFeesPerSubject[$subject->id] = $subjectRemaining;
            }

            $totalRemaining = array_sum($remainingFeesPerSubject);
            
            if ($totalRemaining > 0) {
                foreach ($cstudent->ssubjects as $subject) {
                    if ($remainingFeesPerSubject[$subject->id] > 0) {
                        // Calculate proportional amount for this subject
                        $proportionalAmount = ($remainingFeesPerSubject[$subject->id] / $totalRemaining) * $totalToDistribute;
                        $subjectFeesAmount = min($proportionalAmount, $remainingFeesPerSubject[$subject->id]);
                        
                        // Update the pivot record
                        $currentFeesSubmitted = $subject->pivot->fees_submitted ?? 0;
                        $currentFeesPaid = $subject->pivot->fees_paid ?? 0;
                        $currentExtraDiscount = $subject->pivot->extra_discount ?? 0;
                        $newFeesSubmitted = max($currentFeesSubmitted, $currentFeesPaid) + $subjectFeesAmount;
                        
                        $cstudent->ssubjects()->updateExistingPivot($subject->id, [
                            'fees_submitted'    => $newFeesSubmitted,
                            'fees_paid'         => $newFeesSubmitted, // Keep both columns in sync
                            'extra_discount'    => $currentExtraDiscount,
                            'date_of_submitted' => $request->date_of_submitted_pivot,
                        ]);
                    }
                }
            }

            return redirect()->route('cstudent.index')->with('success', 'Fee submitted successfully!');
        }

        // Handle new student creation
        $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'gender' => 'required|in:male,female,tg',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'address' => 'nullable|string',
            'competition_level' => 'nullable|string|max:255',
            'ssubjects' => 'required|array|min:1',
            'ssubjects.*' => 'exists:ssubjects,id',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();

            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('cstudents', 'public');
            }

            $cstudent = Cstudent::create($data);

            // Attach subjects to the student
            $subjectsData = [];
            foreach ($request->ssubjects as $subjectId) {
                $subject = Ssubject::find($subjectId);
                $subjectsData[$subjectId] = [
                    'fees_paid' => 0,
                    'extra_discount' => 0,
                    'enrollment_date' => now(),
                    'status' => 'enrolled'
                ];
            }
            $cstudent->ssubjects()->attach($subjectsData);

            DB::commit();
            return redirect()->route('cstudent.index')->with('success', 'Competition student added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create student: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified competition student.
     */
    public function edit(Cstudent $cstudent)
    {
        $ssubjects = Ssubject::where('status', 1)->get();
        $selectedSubjects = $cstudent->ssubjects->pluck('id')->toArray();
        return view('cstudent.edit', compact('cstudent', 'ssubjects', 'selectedSubjects'));
    }

    /**
     * Update the specified competition student.
     */
    public function update(Request $request, Cstudent $cstudent)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'gender' => 'required|in:male,female,tg',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'address' => 'nullable|string',
            'competition_level' => 'nullable|string|max:255',
            'ssubjects' => 'required|array|min:1',
            'ssubjects.*' => 'exists:ssubjects,id',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();

            if ($request->hasFile('photo')) {
                if ($cstudent->photo && Storage::disk('public')->exists($cstudent->photo)) {
                    Storage::disk('public')->delete($cstudent->photo);
                }
                $data['photo'] = $request->file('photo')->store('cstudents', 'public');
            }

            $cstudent->update($data);

            // Sync subjects (remove old, add new)
            $subjectsData = [];
            foreach ($request->ssubjects as $subjectId) {
                $existingEnrollment = $cstudent->enrollments()->where('ssubject_id', $subjectId)->first();
                if ($existingEnrollment) {
                    // Keep existing enrollment data
                    $subjectsData[$subjectId] = [
                        'fees_paid' => $existingEnrollment->fees_paid,
                        'extra_discount' => $existingEnrollment->extra_discount,
                        'enrollment_date' => $existingEnrollment->enrollment_date,
                        'status' => $existingEnrollment->status
                    ];
                } else {
                    // New enrollment
                    $subjectsData[$subjectId] = [
                        'fees_paid' => 0,
                        'extra_discount' => 0,
                        'enrollment_date' => now(),
                        'status' => 'enrolled'
                    ];
                }
            }
            $cstudent->ssubjects()->sync($subjectsData);

            DB::commit();
            return redirect()->route('cstudent.index')->with('success', 'Competition student updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update student: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified competition student.
     */
    public function destroy(Cstudent $cstudent)
    {
        if ($cstudent->photo && Storage::disk('public')->exists($cstudent->photo)) {
            Storage::disk('public')->delete($cstudent->photo);
        }

        $cstudent->delete();

        return redirect()->route('cstudent.index')->with('success', 'Competition student deleted successfully!');
    }

    /**
     * Update fees for a specific subject enrollment.
     */
    public function updateFees(Request $request, Cstudent $cstudent)
    {
        $request->validate([
            'ssubject_id' => 'required|exists:ssubjects,id',
            'fees_paid' => 'required|numeric|min:0',
            'extra_discount' => 'nullable|numeric|min:0',
        ]);

        $enrollment = $cstudent->enrollments()->where('ssubject_id', $request->ssubject_id)->first();
        
        if ($enrollment) {
            $enrollment->update([
                'fees_paid' => $request->fees_paid,
                'extra_discount' => $request->extra_discount ?? 0,
            ]);

            return redirect()->back()->with('success', 'Fees updated successfully!');
        }

        return redirect()->back()->with('error', 'Enrollment not found!');
    }

    /**
     * Show student details with comprehensive information
     */
    public function show(Cstudent $cstudent)
    {
        $cstudent->load(['ssubjects' => function ($q) {
            $q->withPivot('fees_paid', 'extra_discount');
        }]);

        return view('cstudent.show', compact('cstudent'));
    }

    /**
     * Print fees receipt for the competition student
     */
    public function printReceipt(Cstudent $cstudent)
    {
        $cstudent->load(['ssubjects' => function ($q) {
            $q->withPivot('fees_submitted', 'fees_paid', 'extra_discount', 'date_of_submitted');
        }]);

        $totalFees = $cstudent->ssubjects->sum('fees');
        $totalPaid = $cstudent->ssubjects->sum(function ($subject) {
            $feesSubmitted = $subject->pivot->fees_submitted ?? 0;
            $feesPaid = $subject->pivot->fees_paid ?? 0;
            $extraDiscount = $subject->pivot->extra_discount ?? 0;
            return max($feesSubmitted, $feesPaid) + $extraDiscount;
        });
        $remaining = max(0, $totalFees - $totalPaid);

        // Fetch payment history using student ID to get subjects from cstudent_ssubject and details from ssubjects
        $allPayments = collect();
        $pivotRecords = DB::table('cstudent_ssubject')
            ->join('ssubjects', 'cstudent_ssubject.ssubject_id', '=', 'ssubjects.id')
            ->where('cstudent_ssubject.cstudent_id', $cstudent->id)
            ->select('cstudent_ssubject.fees_submitted', 'cstudent_ssubject.fees_paid', 'cstudent_ssubject.extra_discount', 'cstudent_ssubject.date_of_submitted', 'ssubjects.subject_name')
            ->orderBy('cstudent_ssubject.date_of_submitted')
            ->get();

        foreach ($pivotRecords as $record) {
            $allPayments->push([
                'subject' => $record->subject_name,
                'date' => $record->date_of_submitted,
                'fees_submitted' => max($record->fees_submitted ?? 0, $record->fees_paid ?? 0),
                'extra_discount' => $record->extra_discount ?? 0,
            ]);
        }

        $user = Auth::user();

        return view('cstudent.receipt', compact('cstudent', 'totalFees', 'totalPaid', 'remaining', 'allPayments', 'user'));
    }

    /**
     * Export students to CSV
     */
    public function export(Request $request)
    {
        $query = Cstudent::with(['ssubjects']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('father_name', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('ssubjects', function ($subjectQuery) use ($search) {
                      $subjectQuery->where('s_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('competition_level')) {
            $query->where('competition_level', $request->competition_level);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $cstudents = $query->get();

        $filename = 'competition_students_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($cstudents) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Name', 'Father Name', 'Mobile', 'Email', 'Gender', 
                'Competition Level', 'Subjects', 'Total Fees', 'Paid Amount', 'Enrollment Date'
            ]);

            foreach ($cstudents as $cstudent) {
                $subjects = $cstudent->ssubjects->pluck('s_name')->implode(', ');
                $totalFees = $cstudent->ssubjects->sum('fees');
                $totalPaid = $cstudent->ssubjects->sum(function ($subject) {
                    return $subject->pivot->fees_submitted + ($subject->pivot->extra_discount ?? 0);
                });

                fputcsv($file, [
                    $cstudent->id,
                    $cstudent->name,
                    $cstudent->father_name ?? '',
                    $cstudent->mobile ?? '',
                    $cstudent->email ?? '',
                    ucfirst($cstudent->gender ?? 'male'),
                    ucfirst($cstudent->competition_level),
                    $subjects,
                    $totalFees,
                    $totalPaid,
                    $cstudent->created_at->format('d/m/Y'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk delete students
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:cstudents,id',
        ]);

        $deletedCount = 0;
        foreach ($request->student_ids as $studentId) {
            $cstudent = Cstudent::find($studentId);
            if ($cstudent) {
                // Delete photo if exists
                if ($cstudent->photo && Storage::disk('public')->exists($cstudent->photo)) {
                    Storage::disk('public')->delete($cstudent->photo);
                }
                $cstudent->delete();
                $deletedCount++;
            }
        }

        return redirect()->route('cstudent.index')->with('success', "Successfully deleted {$deletedCount} competition students.");
    }
}