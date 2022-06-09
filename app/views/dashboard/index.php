<?php

//data total biaya
$totalbiaya = 0;
foreach ($data['dataWorkorder'] as $wo):
  $totalbiaya += $wo['act_biaya'];
endforeach;

$totalwo = count($data['dataWorkorder']);
$open = count($data['open']);
$closed = count($data['closed']);


//grafik status wo
foreach ( $data['grafikStatus'] as $status ):
  $sts[] = $status['status'];
  $ttl[] = $status['total'];
endforeach;
// var_dump($data['grafikJenis']);

//grafik dept
foreach ( $data['grafikDept'] as $dpt ):
  $nama_dp[] = $dpt['kode'];
  $jml_dp[] = $dpt['jml'];
endforeach;
// var_dump($data['grafikDept']);

//grafik biaya per dept
foreach ( $data['grafikbiayaDept'] as $bydpt ):
  $name_dept[] = $bydpt['kode'];
  $cost_dept[] = $bydpt['biaya'];
endforeach;
// var_dump($data['grafikbiayaDept']);


//grafik jenis wo
foreach ( $data['grafikJenis'] as $jns ):
  $jenis[] = $jns['nama_kategori'];
  $n[] = $jns['total'];
endforeach;
// var_dump($data['grafikJenis']);

//grafik jumlah wo
foreach ( $data['grafikWO'] as $jmlwo ):
  $bulan1[] = $jmlwo['bulan'];
  $qty[] = $jmlwo['total'];
endforeach;

//grafik biaya wo
foreach ( $data['grafikBiaya'] as $by ):
  $bulan2[] = $by['bulan'];
  $plan[] = $by['plan'];
  $aktual[] = $by['aktual'];
endforeach;

//grafik progress
foreach ( $data['grafikProgress'] as $prog ):
  $progress[] = $prog['progress'];
  $jml[] = $prog['jml'];
endforeach;

//grafik leadtime
foreach ( $data['grafikLeadtime'] as $lt ):
  $nama_wo_leadtime[] = $lt['nama_wo'];
  $leadtime[] = $lt['leadtime'];
endforeach;


//grafik progress
foreach ($data['grafikTimeline'] as $tl) {
    $data_arr[] = array(
        'x' => $tl['nama_wo'],
        'y' => $tl['tanggal'],
              $tl['finish']
    );
}

$dept = $data['user']['nama_dept'];
$id_role = $data['user']['role'];

if ($id_role == 1 || $id_role == 5 || $id_role == 6 || $id_role == 7 || $id_role == 8){
  $divisi = 'All Dept';
} else {
  $divisi = $dept;
}


?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard <small>(<?= $divisi ?>)</small></h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- Total biaya -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total biaya Work Order</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($totalbiaya); ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-coins fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total wo -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Work Order</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalwo ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-tasks fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total wo -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Work Order (Closed)</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $closed ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-check-circle fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- open -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Work Order (On progress)</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $open ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-play-circle fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- grafik atas-->

  <div class="row">

    <!-- Area Chart -->
    <div class="col-xl-6 col-lg-6">
      <div class="card h-100 shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Jumlah Work Order (Monthly)</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
          </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">          
            <canvas id="workorderChart"></canvas>         

          <!-- //grafik jumlah wo -->
          <script>
            var ctx = document.getElementById('workorderChart').getContext('2d');
            var workorderChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($bulan1); ?>,
                    datasets: [{
                        label: 'Jumlah WO',
                        data: <?= json_encode($qty); ?>,
                        backgroundColor: [
                            'rgba(102, 181, 248, 1)',
                            'rgba(245, 197, 29, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(29, 219, 72, 1)',
                            'rgba(70, 255, 204, 1)',
                            'rgba(213, 255, 115, 1)',
                            'rgba(250, 202, 195 , 1)'
                        ],
                        borderColor: [
                            'rgba(102, 181, 248, 1)',
                            'rgba(245, 197, 29, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(29, 219, 72, 1)',
                            'rgba(70, 255, 204, 1)',
                            'rgba(213, 255, 115, 1)',
                            'rgba(250, 202, 195 , 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: {
                      display: false,
                    },
                    scales: {
                      xAxes: [{
                          gridLines: {
                            drawOnChartArea: false
                          }
                      }],
                      yAxes: [{
                          gridLines: {
                            drawOnChartArea: false
                          },
                          ticks:{
                            min:0,
                            max:100
                          },
                          scaleLabel: {
                            display: true,
                            labelString: 'Jml work order'
                          }
                      }]
                    }
                },
            });

            </script>


        </div>
      </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-6 col-lg-6">
      <div class="card h-100 shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Jumlah Work Order Berdasarkan Kategori</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
          </div>
        </div>

        <!-- grafik jenis work order-->
        <div class="card-body">
            <canvas id="jenisChart"></canvas>

          <script>
          var ctx = document.getElementById('jenisChart').getContext('2d');
          var jenisChart = new Chart(ctx, {
              type: 'pie',
              data: {
                  labels: <?= json_encode($jenis); ?>,
                  datasets: [{
                      label: 'Jenis WO',
                      data: <?= json_encode($n); ?>,
                      backgroundColor: [
                        'rgba(255, 92, 70, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(29, 219, 72, 1)',
                        'rgba(70, 255, 204, 1)',
                        'rgba(213, 255, 115, 1)',
                        'rgba(250, 202, 195 , 1)'
                      ],
                      borderColor: [
                        'rgba(255, 92, 70, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(29, 219, 72, 1)',
                        'rgba(70, 255, 204, 1)',
                        'rgba(213, 255, 115, 1)',
                        'rgba(250, 202, 195 , 1)'
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                  legend: {
                      position: 'bottom',
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            display: false
                        }]
                    }
                }
          });

          </script>

        </div>
      </div>
    </div>
  </div>

  <!-- grafik bawah-->

  <div class="row mt-4">

    <!-- Area Chart -->
    <div class="col-xl-6 col-lg-6">
      <div class="card h-100 shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Biaya Work Order (Plan vs Aktual)</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
          </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">

            <canvas id="biayaChart"></canvas>


          <!-- //grafik biaya -->
          <script>
            var ctx = document.getElementById('biayaChart').getContext('2d');
            var biayaChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($bulan2); ?>,
                    datasets: [{
                        label: 'Plan',
                        data: <?= json_encode($plan); ?>,
                        backgroundColor: [
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)'
                        ],
                        borderColor: [
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)',
                            'rgba(255, 92, 70, 1)'
                        ],
                        borderWidth: 1
                    },
                    {
                        label: 'Aktual',
                        data: <?= json_encode($aktual); ?>,
                        backgroundColor: [
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)'
                        ],
                        borderColor: [
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)',
                            'rgba(102, 181, 248, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: {
                      display: false,
                    },
                    scales: {
                      xAxes: [{
                          gridLines: {
                            drawOnChartArea: false
                          }
                      }],
                      yAxes: [{
                          gridLines: {
                            drawOnChartArea: false
                          },
                          ticks:{
                            min:0,
                            max:10000000
                          },
                          scaleLabel: {
                            display: true,
                            labelString: 'Rupiah'
                          }
                      }]
                    }
                }
            });

            </script>


        </div>
      </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-6 col-lg-6">
      <div class="card h-100 shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Jumlah Work Order Berdasarkan Status</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
          </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">

          <canvas id="statusChart"></canvas>

          <script>
          var ctx = document.getElementById('statusChart').getContext('2d');
          var statusChart = new Chart(ctx, {
              type: 'pie',
              data: {
                  labels: <?= json_encode($sts); ?>,
                  datasets: [{
                      label: 'Status WO',
                      data: <?= json_encode($ttl); ?>,
                      backgroundColor: [
                          'rgba(29, 219, 72, 1)',
                          'rgba(70, 255, 204, 1)',
                          'rgba(255, 92, 70, 1)',
                          'rgba(54, 162, 235, 1)',
                          'rgba(255, 206, 86, 1)',
                          'rgba(75, 192, 192, 1)',
                          'rgba(153, 102, 255, 1)',
                          'rgba(255, 159, 64, 1)',
                          'rgba(213, 255, 115, 1)',
                          'rgba(250, 202, 195 , 1)'
                      ],
                      borderColor: [
                          'rgba(29, 219, 72, 1)',
                          'rgba(70, 255, 204, 1)',
                          'rgba(255, 92, 70, 1)',
                          'rgba(54, 162, 235, 1)',
                          'rgba(255, 206, 86, 1)',
                          'rgba(75, 192, 192, 1)',
                          'rgba(153, 102, 255, 1)',
                          'rgba(255, 159, 64, 1)',
                          'rgba(213, 255, 115, 1)',
                          'rgba(250, 202, 195 , 1)'
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                  legend: {
                      position: 'bottom',
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            display: false
                        }]
                    }
                }
          });

          </script>


        </div>
      </div>
    </div>
  </div>



  <!-- grafik untuk progress status-->

  <div class="row">

    <!-- Area Chart -->
    <div class="col-xl-6 col-lg-6">
      <div class="card h-100 shadow mb-4 mt-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Work Order Berdasarkan Progress Status (Open)</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
          </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">

          <canvas id="progressChart"></canvas>

          <!-- //grafik progress -->
                    <!-- //grafik jumlah wo -->
          <script>
          var ctx = document.getElementById('progressChart').getContext('2d');
          var progressChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: <?= json_encode($progress); ?>,
                  datasets: [{
                      label: 'Progress',
                      data: <?= json_encode($jml); ?>,
                      backgroundColor: [
                          'rgba(102, 181, 248, 1)',
                          'rgba(245, 197, 29, 1)',
                          'rgba(255, 92, 70, 1)',
                          'rgba(54, 162, 235, 1)',
                          'rgba(255, 206, 86, 1)',
                          'rgba(75, 192, 192, 1)',
                          'rgba(153, 102, 255, 1)',
                          'rgba(255, 159, 64, 1)',
                          'rgba(29, 219, 72, 1)',
                          'rgba(70, 255, 204, 1)',
                          'rgba(213, 255, 115, 1)',
                          'rgba(250, 202, 195 , 1)'
                      ],
                      borderColor: [
                          'rgba(102, 181, 248, 1)',
                          'rgba(245, 197, 29, 1)',
                          'rgba(255, 92, 70, 1)',
                          'rgba(54, 162, 235, 1)',
                          'rgba(255, 206, 86, 1)',
                          'rgba(75, 192, 192, 1)',
                          'rgba(153, 102, 255, 1)',
                          'rgba(255, 159, 64, 1)',
                          'rgba(29, 219, 72, 1)',
                          'rgba(70, 255, 204, 1)',
                          'rgba(213, 255, 115, 1)',
                          'rgba(250, 202, 195 , 1)'
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                  legend: {
                    display: false,
                  },
                  scales: {
                    xAxes: [{
                        gridLines: {
                          drawOnChartArea: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                          drawOnChartArea: false
                        },
                        ticks:{
                          min:0,
                          max:20
                        },
                        scaleLabel: {
                          display: true,
                          labelString: 'jml work order'
                        }
                    }]
                  }
              }
          });

          </script>


        </div>
      </div>
    </div>
    <!-- end card grafik progress -->


    <!-- Chart dept -->
    <div class="col-xl-6 col-lg-6">
      <div class="card h-100 shadow mb-4 mt-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Jumlah Work Order Berdasarkan Department</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
          </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">

          <div id="deptChart"></div>

          <!-- //grafik dept -->
          <script type="text/javascript">

          var options = {
            chart: {
              type: 'bar'
            },
            series: [{
              name: 'Department',
              data: <?= json_encode($jml_dp); ?>
            }],
            xaxis: {
              categories: <?= json_encode($nama_dp); ?>
            }
          }

          var chart = new ApexCharts(document.querySelector("#deptChart"), options);

          chart.render();

          </script>


        </div>
      </div>
    </div>
    <!-- end card grafik wo by dept -->


    
  </div>
  <!-- end row -->



    <div class="row mt-4">

    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12">
      <div class="card h-100 shadow mb-4 mt-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Pareto Work Order Berdasarkan Leadtime ( hari kerja )</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
          </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">

          <canvas id="chartleadtime" style="height:40vh; width:80vw"></canvas>
          <script>
          var ctx = document.getElementById('chartleadtime').getContext('2d');
          var progressChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: <?= json_encode($nama_wo_leadtime); ?>,
                  datasets: [{
                      label: 'Progress',
                      data: <?= json_encode($leadtime); ?>,
                      backgroundColor: [
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)',
                          'rgba(255, 140, 140, 1)'
                      ],
                      borderColor: [
                          'rgba(255, 140, 140, 1)'
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                  legend: {
                    display: false,
                  },
                  scales: {
                    xAxes: [{
                        gridLines: {
                          drawOnChartArea: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                          drawOnChartArea: false
                        },
                        ticks:{
                          min:0 
                        },
                        scaleLabel: {
                          display: true,
                          labelString: 'working days'
                        }
                    }]
                  }
              }
          });
          
          </script>


        </div>
      </div>
    </div>
    <!-- end card grafik progress -->

    
  </div>
  <!-- end row -->


<!-- //cek user role  -->
<?php  if ($id_role == 1 || $id_role == 5 || $id_role == 6 || $id_role == 7 || $id_role == 8){ ?>

<!-- //grafik tambahan  -->
  <!-- grafik untuk progress status-->

  <div class="row mt-4">

   <!-- Chart dept -->
    <div class="col-xl-6 col-lg-6">
      <div class="card h-100 shadow mb-4 mt-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Aktual Biaya Work Order Berdasarkan Department</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
          </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">

          <div id="biayadeptChart"></div>

          <!-- //grafik dept -->
          <script type="text/javascript">

          var options = {
            chart: {
              type: 'bar'
            },
            series: [{
              name: 'Department',
              data: <?= json_encode($cost_dept); ?>
            }],
            xaxis: {
              categories: <?= json_encode($name_dept); ?>
            }
          }

          var chart = new ApexCharts(document.querySelector("#biayadeptChart"), options);

          chart.render();

          </script>


        </div>
      </div>
    </div>
    <!-- end card grafik wo by dept -->


    
  </div>
  <!-- end row -->

<?php } ?>








  <!-- //footer -->
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

