@extends('app')

@section('content')
<div class="w-full max-w-[1200px] mx-auto pb-10">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row justify-between lg:items-start mb-6 pt-2 gap-6">
        <h1 class="text-[28px] sm:text-[32px] font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500 tracking-tight">S-Curve Progress</h1>
        
        <!-- Project Identity Card -->
        <div class="flex items-start gap-4 w-full lg:w-auto bg-white/50 lg:bg-transparent p-4 lg:p-0 rounded-2xl lg:rounded-none shadow-sm lg:shadow-none border border-gray-100 lg:border-none">
            <!-- Icon Box -->
            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white border border-gray-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                <i class="fas fa-map-marked-alt text-xl sm:text-2xl text-[#8E9EAC]"></i>
            </div>
            
            <!-- Info Section -->
            <div class="flex flex-col">
                <div class="mb-1.5 flex items-center gap-2">
                    <span class="bg-indigo-500 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm tracking-wide">ACTIVE</span>
                </div>
                <h2 class="text-[16px] sm:text-[18px] font-extrabold text-[#112338] leading-tight mb-1">
                    {{ $project->code ? $project->code . ' - ' : '' }}{{ $project->name }}
                </h2>
                <p class="text-[#72839A] text-[12px] sm:text-[13px] font-medium mb-2">
                    {{ $project->type ?? 'Detailed Engineering Design' }}
                </p>
                
                <div class="flex items-center gap-4 text-[#72839A] text-[11px] font-bold">
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-layer-group text-[#AAB8C7]"></i>
                        <span>{{ $project->disciplines_count ?? 0 }} Disciplines</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-user-friends text-[#AAB8C7]"></i>
                        <span>{{ $project->personnel_count ?? 0 }} Personnel</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Cards Area -->
    <div class="flex flex-col sm:flex-row gap-4 mb-8">
        <div class="bg-indigo-50 border border-gray-200 rounded-xl p-4 w-full sm:w-[280px]">
            <h3 class="font-bold text-indigo-900 text-[13px] mb-2 uppercase tracking-wider">PROJECT PROGRESS</h3>
            <div class="flex items-end gap-3 mb-1">
                <span class="text-[36px] font-light text-indigo-600 leading-none">{{ $project->completion_percentage ?? 56 }}%</span>
                <span class="text-[13px] font-bold text-gray-500 mb-1">Actual</span>
            </div>
            <div class="w-full bg-gray-200 h-2 rounded-full mt-3 overflow-hidden">
                <div class="bg-indigo-600 h-full rounded-full" style="width: {{ $project->completion_percentage ?? 56 }}%;"></div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-4 w-full sm:w-[280px] shadow-sm">
            <h3 class="font-bold text-gray-400 text-[13px] mb-2 uppercase tracking-wider">TARGET PROGRESS</h3>
            <div class="flex items-end gap-3 mb-1">
                <span class="text-[36px] font-light text-gray-700 leading-none">62%</span>
                <span class="text-[13px] font-bold text-gray-400 mb-1">Planned</span>
            </div>
            <div class="w-full bg-gray-100 h-2 rounded-full mt-3 overflow-hidden">
                <div class="bg-gray-300 h-full rounded-full w-[62%]"></div>
            </div>
        </div>
    </div>

    <!-- S-Curve Chart Area -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-8 relative">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-gray-800 text-[15px]">S-Curve Chart - DED</h3>
            <div class="flex gap-6">
                <div id="legend-planned" class="flex items-center gap-2 cursor-pointer transition-opacity hover:opacity-80" onclick="toggleDataset(0)">
                    <div class="w-4 h-1 bg-emerald-500"></div>
                    <span class="text-xs font-bold text-gray-500 select-none">Planned Progress</span>
                </div>
                <div id="legend-actual" class="flex items-center gap-2 cursor-pointer transition-opacity hover:opacity-80" onclick="toggleDataset(1)">
                    <div class="w-4 h-1 bg-indigo-600"></div>
                    <span class="text-xs font-bold text-gray-800 select-none">Actual Progress</span>
                </div>
            </div>
        </div>

        <!-- Chart Area -->
        <div class="relative h-[300px] w-full">
            <canvas id="sCurveChart"></canvas>
        </div>
    </div>

    <!-- Discipline Progress -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @php
            $colors = ['#1B9934', '#FFA600', '#008DDF', '#D32F2F', '#7E57C2'];
        @endphp
        @forelse($disciplines as $index => $disc)
        <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
            <h4 class="text-[13px] font-bold text-gray-800 mb-2">{{ $disc->discipline }}</h4>
            <div class="flex justify-between items-end mb-1">
                <span class="text-xl font-bold text-gray-700">{{ $disc->percentage }}%</span>
            </div>
            <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                <div class="h-full rounded-full" style="background-color: {{ $colors[$index % count($colors)] }}; width: {{ $disc->percentage }}%;"></div>
            </div>
        </div>
        @empty
        <div class="col-span-5 text-sm text-gray-500 py-4">No sprint progress data per discipline yet.</div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('sCurveChart').getContext('2d');
    
    const sCurveChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [
                {
                    label: 'Planned Progress',
                    data: {!! json_encode($plannedData) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#10b981'
                },
                {
                    label: 'Actual Progress',
                    data: {!! json_encode($actualData) !!},
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#4f46e5'
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

    window.toggleDataset = function(index) {
        const isVisible = sCurveChart.isDatasetVisible(index);
        sCurveChart.setDatasetVisibility(index, !isVisible);
        sCurveChart.update();
        
        const legendId = index === 0 ? 'legend-planned' : 'legend-actual';
        const el = document.getElementById(legendId);
        if (isVisible) {
            el.classList.add('opacity-40', 'grayscale');
        } else {
            el.classList.remove('opacity-40', 'grayscale');
        }
    };
});
</script>
@endsection
