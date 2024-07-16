<x-app-layout>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Leaderboard</h1>
    <table class="w-full table-auto border-collapse border border-gray-200">
        <thead>
            <tr>
                <th class="border border-gray-300 p-2">Rank</th>
                <th class="border border-gray-300 p-2">Leader Name</th>
                <th class="border border-gray-300 p-2">Issues Resolved</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leaders as $index => $leader)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                    <td class="border border-gray-300 p-2">{{ $index + 1 }}</td>
                    <td class="border border-gray-300 p-2">{{ $leader->name }}</td>
                    <td class="border border-gray-300 p-2">{{ $leader->issues_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-app-layout>

