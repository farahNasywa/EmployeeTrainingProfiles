@extends('layout.master')

@section('content')

<style>
.dash-card {
    border: none;
    border-radius: 14px;
    padding: 22px 24px;
    color: #fff;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.dash-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}

.dash-card::after {
    content: "";
    position: absolute;
    right: -20px;
    bottom: -20px;
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: rgba(255,255,255,0.12);
}

.dash-card .dash-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    background: rgba(255,255,255,0.18);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 14px;
}

.dash-card h2 {
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 2px;
}

.dash-card p {
    font-size: 13px;
    opacity: 0.9;
    margin-bottom: 0;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

.bg-grad-blue   { background: linear-gradient(135deg, #0F3387, #1b4ab8); }
.bg-grad-green  { background: linear-gradient(135deg, #0f9d58, #34c77b); }
.bg-grad-orange { background: linear-gradient(135deg, #e08e0b, #f5a623); }
.bg-grad-purple { background: linear-gradient(135deg, #6a3ec1, #9b6fe0); }

.panel-card {
    background: #fff;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    height: 100%;
}

.panel-card h5 {
    font-weight: 700;
    color: #0F3387;
    margin-bottom: 18px;
}

.recent-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #f0f1f5;
}

.recent-item:last-child {
    border-bottom: none;
}

.recent-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(15,51,135,0.1);
    color: #0F3387;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    margin-right: 12px;
}

.recent-name {
    font-weight: 600;
    font-size: 14px;
    color: #212529;
    margin-bottom: 2px;
}

.recent-sub {
    font-size: 12px;
    color: #8a90a2;
}

.badge-level {
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}
</style>

<!--begin::App Content Header-->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
        </div>
    </div>
</div>
<!--end::App Content Header-->

<!--begin::App Content-->
<div class="app-content">
    <div class="container-fluid">

        <!--begin::Stat Cards-->
        <div class="row g-3 mb-4">
            <div class="col-lg-3 col-6">
                <div class="dash-card bg-grad-blue">
                    <div class="dash-icon"><i class="bi bi-people-fill"></i></div>
                    <h2>{{ $totalPegawai ?? 0 }}</h2>
                    <p>Total Employees</p>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="dash-card bg-grad-green">
                    <div class="dash-icon"><i class="bi bi-diagram-3-fill"></i></div>
                    <h2>{{ $totalDivisi ?? 0 }}</h2>
                    <p>Total Divisions</p>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="dash-card bg-grad-orange">
                    <div class="dash-icon"><i class="bi bi-person-badge-fill"></i></div>
                    <h2>{{ $totalDeputi ?? 0 }}</h2>
                    <p>Total Deputies</p>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="dash-card bg-grad-purple">
                    <div class="dash-icon"><i class="bi bi-person-plus-fill"></i></div>
                    <h2>{{ $pegawaiBaruBulanIni ?? 0 }}</h2>
                    <p>New This Month</p>
                </div>
            </div>
        </div>
        <!--end::Stat Cards-->

        <!--begin::Chart & Recent-->
        <div class="row g-3">
            <div class="col-lg-7">
                <div class="panel-card">
                    <h5><i class="bi bi-bar-chart-fill me-2"></i>Employee Distribution by Level</h5>
                    <div id="levelChart"></div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="panel-card">
                    <h5><i class="bi bi-clock-history me-2"></i>Newest Employees</h5>

                    @forelse(($recentEmployees ?? []) as $employee)
                        <div class="recent-item">
                            <div style="display:flex; align-items:center;">
                                <div class="recent-avatar">
                                    {{ strtoupper(substr($employee->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="recent-name">{{ $employee->nama }}</div>
                                    <div class="recent-sub">{{ $employee->bidang }}</div>
                                </div>
                            </div>
                            <span class="badge-level"
                                  style="background: rgba(15,51,135,0.1); color:#0F3387;">
                                {{ $employee->level }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No employee data yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <!--end::Chart & Recent-->

    </div>
</div>
<!--end::App Content-->

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const levelData = {!! json_encode($levelChartData ?? ['JUNIOR' => 0, 'PRACTICIONER' => 0, 'PROFESIONAL' => 0, 'EXPERT' => 0]) !!};

    const options = {
        chart: {
            type: 'donut',
            height: 300,
        },
        series: Object.values(levelData),
        labels: Object.keys(levelData),
        colors: ['#0F3387', '#0f9d58', '#f5a623', '#6a3ec1'],
        legend: {
            position: 'bottom',
        },
        dataLabels: {
            enabled: true,
        },
    };

    const chart = new ApexCharts(document.querySelector("#levelChart"), options);
    chart.render();
});
</script>
@endsection