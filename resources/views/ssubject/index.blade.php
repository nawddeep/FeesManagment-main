<x-layout.default>
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h5 class="font-semibold text-lg dark:text-white-light">Competition Subjects</h5>
            <a href="{{ route('ssubject.create') }}" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Subject
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table-hover">
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Fees</th>
                        <th>Discount (%)</th>
                        <th>Description</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ssubjects as $subject)
                        <tr>
                            <td class="whitespace-nowrap font-semibold">{{ $subject->subject_name }}</td>
                            <td>₹{{ number_format($subject->fees ?? 0, 2) }}</td>
                            <td>{{ $subject->discount ?? 0 }}%</td>
                            <td class="max-w-xs truncate" title="{{ $subject->description }}">
                                {{ $subject->description ?? 'No description' }}
                            </td>
                            <td class="text-center whitespace-nowrap">
                                <span class="badge {{ $subject->status ? 'badge-outline-success' : 'badge-outline-danger' }}">
                                    {{ $subject->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-center flex items-center justify-center gap-2">
                                <!-- Edit Button -->
                                <a href="{{ route('ssubject.edit', $subject->id) }}" x-tooltip="Edit">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.586-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.414-8.414z" />
                                    </svg>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('ssubject.destroy', $subject->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this subject?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" x-tooltip="Delete">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">No subjects found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout.default>