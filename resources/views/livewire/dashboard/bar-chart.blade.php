<div class="lg:col-span-2 bg-white p-4 rounded-2xl shadow-md">
    <p class="font-semibold mb-2">📊 Statistik Surat Bulanan</p>
    <div class="h-64">
        <canvas id="barChart"></canvas>
    </div>
</div>

@push('scripts')
<script>
    const ctx = document.getElementById("barChart").getContext("2d");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
            datasets: [{
                    label: "Surat Masuk",
                    data: [20, 35, 40, 25, 50, 30],
                    backgroundColor: "rgba(139, 92, 246, 0.7)"
                },
                {
                    label: "Surat Keluar",
                    data: [15, 25, 30, 20, 40, 25],
                    backgroundColor: "rgba(34, 211, 238, 0.7)"
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "bottom"
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

</script>
@endpush
