const apiUrl = "http://127.0.0.1:8000/api/getData";



document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById("chart");

    // Ambil data JSON dari server
    fetch('/api/getData')
    .then(response => response.json())
    .then(data => {
        const labels = Object.keys(data); // Tanggal sebagai label
        const kembaliData = Object.values(data).map(item => item.jumlahPengembalian);
        const pinjamData = Object.values(data).map(item => item.jumlahPeminjaman);
        const keterlambatanData = Object.values(data).map(item => item.jumlahKeterlambatan);
  
        const ctx = document.getElementById('chart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Jumlah Transaksi Kembali',
                        data: kembaliData,
                        backgroundColor: '#5CB85C',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Jumlah Transaksi Pinjam',
                        data: pinjamData,
                        backgroundColor: '#5BC0DE',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Jumlah Keterlambatan',
                        data: keterlambatanData,
                        backgroundColor: '#D9534F',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              legend: {
                position: "bottom"
              },
              scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Tanggal' // Label untuk sumbu X
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Jumlah' // Label untuk sumbu Y
                    }
                }]
            }
            }
        });
    });
})