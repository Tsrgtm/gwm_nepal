<div class="container mx-auto px-4 py-8">
    <div class="space-y-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg rounded-xl p-4 flex flex-col items-center justify-center text-gray-100">
                <h2 class="text-2xl font-bold">{{$totalClicks}}</h2>
                <h4>Total Clicks</h4>
            </div>

            <div class="bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg rounded-xl p-4 flex flex-col items-center justify-center text-gray-100">
                <h2 class="text-2xl font-bold">{{$convertedClicks}}</h2>
                <h4>Converted Clicks</h4>
            </div>

            <div class="bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg rounded-xl p-4 flex flex-col items-center justify-center text-gray-100">
                <h2 class="text-2xl font-bold">{{$totalUniqueClicks}}</h2>
                <h4>Unique Clicks</h4>
            </div>

            <div class="bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg rounded-xl p-4 flex flex-col items-center justify-center text-gray-100">
                <h2 class="text-2xl font-bold">{{$totalForms}}</h2>
                <h4>Total Forms</h4>
            </div>
        </div>
    </div>
    @if ($totalForms > 0)
        <div class="flex justify-end">
            <a href="{{ route('ads.export') }}" class=" bg-red-500 text-gray-100 px-4 py-1 rounded-t hover:bg-red-600  hover:text-white flex items-center justify-center transition duration-500"><i class="fas fa-download mr-2"></i>Download Data</a>
        </div>
    @endif
    <div class="bg-white shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-red-600 text-white flex items-center justify-between">
            <h2 class="text-lg font-semibold">Form Submissions</h2>
            <div>
                <div class="relative">
                    <input
                    class="w-full bg-white placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md pr-3 pl-10 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                    placeholder="Search" 
                    type="text"
                   wire:model.live.debounce.500ms="search"
                    />
                    <button class="absolute left-3 top-0 h-full"
                    type="button">
                        <i class="fas fa-search text-slate-400"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Wrapper -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wide font-medium border-b">
                        <th class="px-6 py-4 w-1/12">ID</th>
                        <th class="px-6 py-4 w-1/12">Name</th>
                        <th class="px-6 py-4 w-2/12">Email</th>
                        <th class="px-6 py-4 w-1/12">Phone</th>
                        <th class="px-6 py-4 w-2/12">Location</th>
                        <th class="px-6 py-4 w-2/12">Message</th>
                        <th class="px-6 py-4 w-1/12">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @if ($adsForms->isNotEmpty())
                        @foreach ($adsForms as $adsForm)
                            <tr class="hover:bg-gray-50 transition-all duration-200 text-gray-700">
                                <td class="px-6 py-4 text-center font-mono text-sm">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 truncate max-w-[150px]">{{ $adsForm->name }}</td>
                                <td class="px-6 py-4 truncate max-w-[200px]">
                                    <a href="mailto:{{ $adsForm->email }}" class="text-blue-600 hover:underline">
                                        {{ $adsForm->email }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 font-mono text-sm">{{ $adsForm->phone }}</td>
                                <td class="px-6 py-4 truncate max-w-[150px]">{{ $adsForm->location }}</td>
                                <td class="px-6 py-4 truncate max-w-[200px]">{{ $adsForm->message ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if ($adsForm->status === 'pending')
                                            bg-yellow-100 text-yellow-800
                                        @elseif ($adsForm->status === 'approved')
                                            bg-green-100 text-green-800
                                        @else
                                            bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($adsForm->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    
                    @else
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No submissions found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($adsForms->hasPages())
            <div class="px-6 py-4">
                {{ $adsForms->links() }}
            </div>
        
        @endif
    </div>
</div>