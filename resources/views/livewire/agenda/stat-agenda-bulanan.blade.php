<div>
    {{--
        Wadah untuk Chart.
        ID ini akan digunakan oleh JavaScript (ApexCharts) untuk me-render grafik.
    --}}
    <div id="apexChartContainer"></div>

    {{--
        Skrip JavaScript untuk me-render ApexCharts.
        Kita menggunakan Livewire hooks 'dom:load' untuk memastikan elemen sudah dimuat.
    --}}
    <script>
        // Pastikan ApexCharts sudah dimuat sebelum skrip ini dijalankan
        document.addEventListener('livewire:initialized', () => {
            // Data awal dari Livewire component
            const initialDataPoints = @json($dataPoints);
            const initialLabels = @json($labels);

            // Konfigurasi Chart
            var options = {
                chart: {
                    type: 'bar', // Anda bisa ganti tipe chart
                    height: 350,
                    id: 'salesChart' // ID unik untuk chart, penting untuk pembaruan
                },
                series: [{
                    name: 'Agenda Diajukan',
                    data: initialDataPoints
                }],
                xaxis: {
                    categories: initialLabels
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '20%', // Mengubah lebar batang
                        borderRadius: 5, // Membuat sudut batang membulat
                    },
                },
                dataLabels: {
                    enabled: false // <-- Atur ini menjadi 'false'
                },
                // title: {
                //     text: 'Data Agenda Tahun ' + currentYear
                // }
            };

            // Inisialisasi Chart
            var chart = new ApexCharts(document.querySelector("#apexChartContainer"), options);
            chart.render();
        });

        // --- Contoh Penanganan Pembaruan Data (Jika Anda memiliki fitur update) ---
        /*
        document.addEventListener('livewire:update-chart', (event) => {
            // Ambil data baru yang dipancarkan dari component PHP
            const newDataPoints = event.detail.dataPoints;
            const newLabels = event.detail.labels;

            // Perbarui Series (nilai)
            ApexCharts.exec('salesChart', 'updateSeries', [{
                data: newDataPoints
            }]);

            // Perbarui Label (sumbu X)
            ApexCharts.exec('salesChart', 'updateOptions', {
                xaxis: {
                    categories: newLabels
                }
            });
        });
        */
    </script>
</div>
