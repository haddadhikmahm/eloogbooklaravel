@extends('app')

@section('content')
<div class="w-full max-w-[1200px] mx-auto pb-10">
    <!-- Header -->
    <div class="flex justify-between items-start mb-6 pt-2">
        <h1 class="text-[28px] font-bold text-[#6D6257]">S-Curve Progress</h1>
        
        <div class="flex gap-4">
            <div class="bg-[#F8F5F2] border border-[#EBE6E0] rounded-xl p-4 w-[280px]">
                <h3 class="font-bold text-[#6D6257] text-[13px] mb-2 uppercase tracking-wider">PROJECT PROGRESS</h3>
                <div class="flex items-end gap-3 mb-1">
                    <span class="text-[36px] font-light text-[#A3978B] leading-none">{{ $project->completion_percentage ?? 56 }}%</span>
                    <span class="text-[13px] font-bold text-gray-500 mb-1">Actual</span>
                </div>
                <div class="w-full bg-[#EBE6E0] h-2 rounded-full mt-3 overflow-hidden">
                    <div class="bg-[#867B6F] h-full rounded-full" style="width: {{ $project->completion_percentage ?? 56 }}%;"></div>
                </div>
            </div>

            <div class="bg-white border border-[#EBE6E0] rounded-xl p-4 w-[280px] shadow-sm">
                <h3 class="font-bold text-gray-400 text-[13px] mb-2 uppercase tracking-wider">TARGET PROGRESS</h3>
                <div class="flex items-end gap-3 mb-1">
                    <span class="text-[36px] font-light text-gray-700 leading-none">62%</span>
                    <span class="text-[13px] font-bold text-gray-400 mb-1">Planned</span>
                </div>
                <div class="w-full bg-[#F3F0EC] h-2 rounded-full mt-3 overflow-hidden">
                    <div class="bg-[#DCD3CB] h-full rounded-full w-[62%]"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- S-Curve Chart Area -->
    <div class="bg-white border border-[#EBE6E0] rounded-xl shadow-sm p-6 mb-8 relative">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-gray-800 text-[15px]">Kurva S - Pekerjaan DED</h3>
            <div class="flex gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-1 bg-[#DCD3CB]"></div>
                    <span class="text-xs font-bold text-gray-500">Planned Progress</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-1 bg-[#8C7B6C]"></div>
                    <span class="text-xs font-bold text-gray-800">Actual Progress</span>
                </div>
            </div>
        </div>

        <!-- Chart Area -->
        <div class="relative h-[300px] w-full">
            <canvas id="sCurveChart"></canvas>
        </div>
    </div>

    <!-- Progress Disiplin -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @php
            $colors = ['#1B9934', '#FFA600', '#008DDF', '#D32F2F', '#7E57C2'];
        @endphp
        @forelse($disciplines as $index => $disc)
        <div class="bg-white border border-[#EBE6E0] rounded-xl p-4 shadow-sm">
            <h4 class="text-[13px] font-bold text-gray-800 mb-2">{{ $disc->discipline }}</h4>
            <div class="flex justify-between items-end mb-1">
                <span class="text-xl font-bold text-gray-700">{{ $disc->percentage }}%</span>
            </div>
            <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                <div class="h-full rounded-full" style="background-color: {{ $colors[$index % count($colors)] }}; width: {{ $disc->percentage }}%;"></div>
            </div>
        </div>
        @empty
        <div class="col-span-5 text-sm text-gray-500 py-4">Belum ada data progres sprint per disiplin.</div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('sCurveChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [
                {
                    label: 'Planned Progress',
                    data: {!! json_encode($plannedData) !!},
                    borderColor: '#DCD3CB',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    tension: 0.4,
                    pointRadius: 0
                },
                {
                    label: 'Actual Progress',
                    data: {!! json_encode($actualData) !!},
                    borderColor: '#8C7B6C',
                    backgroundColor: 'rgba(140, 123, 108, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#8C7B6C'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + '%';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: '#f3f4f6',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 25,
                        color: '#9ca3af',
                        font: { size: 10 }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#9ca3af',
                        font: { size: 11, weight: 'bold' }
                    }
                }
            }
        }
    });
});
</script>
@endsection
