const apiUrl = "http://127.0.0.1:8000/api/getData";

document.addEventListener("DOMContentLoaded", function() {
  const ctx = document.getElementById("chart");


  
  fetch(apiUrl)
    .then(response => response.json())
    .then(response => data = [
      {
        label:'Transaksi Kembali', count: response.jumlahTransaksiKembali, backgroundColor: "#5CB85C"
      },
      {
        label:'Transaksi Pinjam', count:response.jumlahTransaksiPinjam, backgroundColor: "#5BC0DE"
      },
      {
        label:"Jumlah Keterlambatan", count:response.jumlahKeterlambatan, backgroundColor: "#D9534F"
      }
    ])
    .then(data => new Chart(
      ctx.getContext("2d"), {
        type: 'doughnut',
        data: {
            labels: data.map(row => row.label),
            datasets: [
                {
                    label: 'Jumlah',
                    data: data.map(row => row.count),
                    backgroundColor: data.map(row => row.backgroundColor),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
              legend: {
                position: "right"
              },
              tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return `${tooltipItem.label}: ${tooltipItem.raw}`;
                    }
                }
            }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    }
    ))
    .catch(e => console.error(e));
})