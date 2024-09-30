@extends('layouts.myapp')



@section('content')


<div class="row">

    <canvas id="myChart" width="400" height="200" class="mb-5"></canvas>

    
    <div class="col-lg-6">
        <canvas id="myPieChart" width="200" height="200"></canvas>
    </div>


    <div class="col-lg-6">
        <div class="row">
            

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-center bg-light text-dark shadow-lg">
                        <span class="fw-semibold d-block mb-3 fs-5"> Nguyên liệu BHCK </span>
                        <h1 class="card-title mb-2 text-dark">{{$total_bhck /1000}} tấn</h1>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-center bg-dark text-white shadow-lg">
                        <span class="fw-semibold d-block mb-3 fs-5">Nguyên liệu CRCK2</span>
                        <h1 class="card-title mb-2 text-white">{{$total_crck2 /1000}} tấn</h1>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-center bg-dark text-white shadow-lg">
                        <span class="fw-semibold d-block mb-3 fs-5">Số lô tháng {{\Carbon\Carbon::createFromFormat('d/m/Y', $date)->format('n')}} </span>
                        <h1 class="card-title mb-2 text-white">{{$totalBatches}}</h1>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-center bg-light text-dark shadow-lg">
                        <span class="fw-semibold d-block mb-3 fs-5">Lệnh xuất hàng</span>
                        <h1 class="card-title mb-2 text-dark">{{$orders}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    

</div>


<script>

    function getRandomPastelColor() {
        const r = Math.floor(Math.random() * 127 + 127); 
        const g = Math.floor(Math.random() * 127 + 127);
        const b = Math.floor(Math.random() * 127 + 127);
        return `rgba(${r}, ${g}, ${b})`;
    }

    document.addEventListener('DOMContentLoaded', function () {

        fetch('/get-data')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); 
        })
        .then(data => {
            // console.log(data.bhck, data.crck2);

            const ctx = document.getElementById('myChart').getContext('2d');
            const ctx2 = document.getElementById('myPieChart').getContext('2d');

            const backgroundColors = data.khoi_luong.map(() => getRandomPastelColor());

            const myChart = new Chart(ctx, {
                type: 'bar', 
                data: {
                    labels: data.nha_u,
                    datasets: [{
                        label: 'Khối lượng cao su (tấn)',
                        data: data.khoi_luong,
                        backgroundColor: backgroundColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });


            const myPieChart = new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Dây Chuyền 3 tấn', 'Dây Chuyền 6 tấn'], 
                    datasets: [{
                        label: 'Số thùng',
                        data: data.thung,
                        backgroundColor: [
                            'rgba(255, 99, 132)', 
                            'rgba(54, 162, 235)'
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `${tooltipItem.label}: ${tooltipItem.raw}`; 
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Số thùng trong ngày' 
                        },
                        datalabels: {
                            anchor: 'center',
                            align: 'center',
                            formatter: (value) => {
                                return value; 
                            },
                            color: 'white',
                            font: {
                                size: 20, 
                                weight: 'bold' 
                            }
                        },
                        
                    }
                },
                plugins: [ChartDataLabels]
            });
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    });
</script>





<style>
    .card {
        margin-bottom: 24px;
    }
</style>




@endsection