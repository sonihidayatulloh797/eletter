<div class="bg-white p-4 rounded-2xl shadow-md">
    <p class="font-semibold mb-2">🥧 Distribusi Surat</p>
    <div class="h-64">
      <canvas id="pieChart"></canvas>
    </div>
  </div>
  
  @push('scripts')
  <script>
    const pieCtx = document.getElementById("pieChart").getContext("2d");
    new Chart(pieCtx, {
      type: "pie",
      data: {
        labels: ["Fakultas Teknik", "Fakultas Hukum", "Fakultas Ekonomi"],
        datasets: [{
          data: [40, 30, 30],
          backgroundColor: [
            "rgba(139, 92, 246, 0.7)",
            "rgba(34, 211, 238, 0.7)",
            "rgba(59, 130, 246, 0.7)"
          ],
          borderColor: ["#fff","#fff","#fff"],
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: "bottom" } }
      }
    });
  </script>
  @endpush
  