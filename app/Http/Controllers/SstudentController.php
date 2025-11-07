<?php

namespace App\Http\Controllers;

use App\Models\sclass;
use App\Models\sstudent;
use App\Models\sfees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SstudentController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index(Request $request)
    {
        $query = sstudent::with(['class', 'fees']);

        // Simple search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('father_name', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('class', function ($classQuery) use ($search) {
                      $classQuery->where('c_name', 'like', "%{$search}%");
                  });
            });
        }

        $students = $query->latest()->paginate(15)->withQueryString();

        return view('sstudent.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $classes = sclass::all();
        return view('sstudent.create', compact('classes'));
    }

    /**
     * Store a newly created student or fee entry.
     */
    public function store(Request $request)
    {
        // If the request is for fee submission
        if ($request->has('fees_submitted')) {
            $request->validate([
                'student_id'        => 'required|exists:sstudents,id',
                'fees_submitted'    => 'required|numeric|min:0',
                'extra_discount'    => 'nullable|numeric|min:0',
                'date_of_submitted' => 'required|date',
            ]);

            $student = sstudent::with('class', 'fees')->findOrFail($request->student_id);
            $totalClassFee = $student->class->fees ?? 0;
            $alreadyPaid = $student->fees->sum('fees_submitted');

            $remaining = $totalClassFee - $alreadyPaid;

            $feesToSubmit = $request->fees_submitted;

            if ($feesToSubmit > $remaining) {
                return redirect()->back()->withErrors(['fees_submitted' => "Cannot submit more than remaining fees (₹$remaining)."]);
            }

            sfees::create([
                'student_id'        => $request->student_id,
                'fees_submitted'    => $feesToSubmit,
                'extra_discount'    => $request->extra_discount ?? 0,
                'date_of_submitted' => $request->date_of_submitted,
            ]);

            return redirect()->route('sstudent.index')->with('success', 'Fee submitted successfully!');
        }

        // Otherwise, handle student creation
        $request->validate([
            'class_id'    => 'required|exists:sclasses,id',
            'name'        => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mobile'      => 'nullable|string|max:15',
            'email'       => 'nullable|email|max:255',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        sstudent::create($data);

        return redirect()->route('sstudent.index')->with('success', 'Student added successfully!');
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(sstudent $sstudent)
    {
        $classes = sclass::all();
        return view('sstudent.edit', compact('sstudent', 'classes'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, sstudent $sstudent)
    {
        $request->validate([
            'class_id'    => 'required|exists:sclasses,id',
            'name'        => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mobile'      => 'nullable|string|max:15',
            'email'       => 'nullable|email|max:255',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            if ($sstudent->photo && Storage::disk('public')->exists($sstudent->photo)) {
                Storage::disk('public')->delete($sstudent->photo);
            }
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        $sstudent->update($data);

        return redirect()->route('sstudent.index')->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(sstudent $sstudent)
    {
        if ($sstudent->photo && Storage::disk('public')->exists($sstudent->photo)) {
            Storage::disk('public')->delete($sstudent->photo);
        }

        $sstudent->delete();

        return redirect()->route('sstudent.index')->with('success', 'Student deleted successfully!');
    }

    /**
     * Show student details with comprehensive information
     */
    public function show(sstudent $sstudent)
    {
        $sstudent->load(['class', 'fees' => function ($q) {
            $q->latest();
        }]);

        $totalClassFee = $sstudent->class->fees ?? 0;
        $totalPaid = $sstudent->fees->sum('fees_submitted') + $sstudent->fees->sum('extra_discount');
        $remaining = max(0, $totalClassFee - $totalPaid);

        return view('sstudent.show', compact('sstudent', 'totalClassFee', 'totalPaid', 'remaining'));
    }

    /**
     * Print fees receipt for the student
     */
    public function printReceipt(sstudent $sstudent)
    {
        $sstudent->load(['class', 'fees' => function ($q) {
            $q->latest();
        }]);

        $totalClassFee = $sstudent->class->fees ?? 0;
        $totalPaid = $sstudent->fees->sum('fees_submitted') + $sstudent->fees->sum('extra_discount');
        $remaining = max(0, $totalClassFee - $totalPaid);

        return view('sstudent.receipt', compact('sstudent', 'totalClassFee', 'totalPaid', 'remaining'));
    }

    /**
     * Export students to CSV
     */
    public function export(Request $request)
    {
        $query = sstudent::with(['class', 'fees']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('father_name', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('class', function ($classQuery) use ($search) {
                      $classQuery->where('c_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $students = $query->get();

        $filename = 'school_students_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($students) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Name', 'Father Name', 'Mobile', 'Email', 'Gender', 
                'Class', 'Total Fees', 'Paid Amount', 'Remaining', 'Status', 'Enrollment Date'
            ]);

            foreach ($students as $student) {
                $totalClassFee = $student->class->fees ?? 0;
                $totalPaid = $student->fees->sum('fees_submitted') + $student->fees->sum('extra_discount');
                $remaining = max(0, $totalClassFee - $totalPaid);
                $status = $remaining > 0 ? 'Pending' : 'Paid';

                fputcsv($file, [
                    $student->id,
                    $student->name,
                    $student->father_name ?? '',
                    $student->mobile ?? '',
                    $student->email ?? '',
                    ucfirst($student->gender ?? 'male'),
                    $student->class->c_name ?? 'N/A',
                    $totalClassFee,
                    $totalPaid,
                    $remaining,
                    $status,
                    $student->created_at->format('d/m/Y'),
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
            'student_ids.*' => 'exists:sstudents,id',
        ]);

        $deletedCount = 0;
        foreach ($request->student_ids as $studentId) {
            $student = sstudent::find($studentId);
            if ($student) {
                // Delete photo if exists
                if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                    Storage::disk('public')->delete($student->photo);
                }
                $student->delete();
                $deletedCount++;
            }
        }

        return redirect()->route('sstudent.index')->with('success', "Successfully deleted {$deletedCount} students.");
    }
}
