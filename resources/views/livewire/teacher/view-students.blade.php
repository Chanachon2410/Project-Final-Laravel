<div>
    <div class="p-6">
        <h1 class="text-2xl font-bold">My Advised Students</h1>

        <div class="mt-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Registration Status (Current Semester)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($students as $student)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap">{{ $student->user->username }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                {{ $student->registrations->where('semester', 1)->where('year', 2025)->first()->status ?? 'Not Registered' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
