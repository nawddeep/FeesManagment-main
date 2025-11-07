<x-layout.default>
    <div class="panel">
        <!-- Header with Actions -->
        <div class="flex items-center justify-between mb-5">
            <h5 class="font-semibold text-lg dark:text-white-light">Competition Students</h5>
            <div class="flex items-center space-x-3">
                <a href="{{ route('sclass.create') }}" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add class
                </a>
            </div>
        </div>

<!-- hover table -->
<div class="table-responsive">
    <table class="table-hover">
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Fees</th>
                <th>Discount (%)</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sclasses as $class)
                <tr>
                    <td class="whitespace-nowrap">{{ $class->c_name }}</td>
                    <td>{{ number_format($class->fees, 2) }}</td>
                    <td>{{ $class->discount   }}</td>
                    <td class="text-center whitespace-nowrap 
                        {{ $class->status ? 'text-success' : 'text-danger' }}">
                        {{ $class->status ? 'Active' : 'Inactive' }}
                    </td>
                    <td class="text-center flex items-center justify-center gap-2">
                        <!-- Edit Button -->
                        <a href="{{ route('sclass.edit', $class->id) }}" x-tooltip="Edit">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.586-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.414-8.414z" />
                            </svg>
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('sclass.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this class?')">
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
            @endforeach
        </tbody>
    </table>
</div>
</x-layout.default>