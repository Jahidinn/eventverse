@extends('dashboard.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header pb-0">
        <div class="page-header-modern mb-3">
            <div class="page-header-left">

                <div class="page-header-icon">
                    <i class="ti ti-layout-grid"></i>
                </div>

                <h2 class="page-header-title">
                    DASHBOARD PAGE
                </h2>

            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content p-0">

        <style>

        .dashboard-hero{

            position:relative;

            overflow:hidden;

            background:
                linear-gradient(
                    135deg,
                    #5285f4,
                    #417dde
                );

            border-radius:24px;

            padding:30px;

            color:white;

            margin-bottom:20px;

            box-shadow:
                0 12px 40px rgba(37,99,235,.18);
        }

        .dashboard-hero::before{

            content:'';

            position:absolute;

            width:250px;
            height:250px;

            border-radius:50%;

            background:rgba(255,255,255,.08);

            right:-60px;
            top:-60px;
        }

        .hero-title{

            font-size:28px;
            font-weight:700;

            margin-bottom:8px;
        }

        .hero-subtitle{

            opacity:.9;

            margin-bottom:20px;
        }

        .hero-stats{

            display:flex;
            gap:12px;
            flex-wrap:wrap;

            margin-bottom:20px;
        }

        .hero-chip{

            padding:8px 14px;

            border-radius:999px;

            background:rgba(255,255,255,.12);

            backdrop-filter:blur(6px);

            font-size:13px;
            font-weight:600;
        }

        .hero-actions{

            display:flex;
            gap:10px;
            flex-wrap:wrap;
        }

        .hero-btn{

            border:none;

            border-radius:12px;

            padding:10px 16px;

            font-weight:600;

            text-decoration:none;
        }

        .hero-btn-primary{

            background:white;
            color:#2563eb;
        }

        .hero-btn-secondary{

            background:rgba(255,255,255,.12);
            color:white;
        }

        .dashboard-stat{

            border:none;

            background:#fff;

            border-radius:22px;

            padding:20px;

            height:100%;

            box-shadow:
                0 4px 20px rgba(0,0,0,.06);

            transition:.25s;
        }

        .dashboard-stat:hover{

            transform:translateY(-3px);

            box-shadow:
                0 14px 40px rgba(0,0,0,.10);
        }

        .dashboard-icon{

            width:52px;
            height:52px;

            border-radius:16px;

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:22px;

            margin-bottom:16px;
        }

        .icon-blue{
            background:rgba(59,130,246,.10);
            color:#2563eb;
        }

        .icon-red{
            background:rgba(239,68,68,.10);
            color:#dc2626;
        }

        .icon-green{
            background:rgba(16,185,129,.10);
            color:#059669;
        }

        .icon-purple{
            background:rgba(139,92,246,.10);
            color:#7c3aed;
        }

        .dashboard-label{

            color:#64748b;

            font-size:14px;

            margin-bottom:6px;
        }

        .dashboard-value{

            font-size:32px;

            font-weight:700;

            color:#0f172a;
        }

        .dashboard-subtitle{

            font-size:12px;

            color:#94a3b8;

            margin-top:8px;
        }

        @media(max-width:768px){

            .dashboard-hero{
                padding:22px;
            }

            .hero-title{
                font-size:22px;
            }

            .dashboard-value{
                font-size:24px;
            }

        }

        </style>

        <div class="dashboard-hero m-2">

            <div class="hero-title">

                Halo,
                {{ explode(' ', auth()->user()->name)[0] }}
                👋

            </div>

            <div class="hero-subtitle">

                Selamat datang kembali di EventHub.
                Kelola event, pantau peserta, dan tingkatkan performa eventmu.

            </div>

            <div class="hero-stats">

                <div class="hero-chip">
                    🎉 {{ number_format($eventDibuat,0,',','.') }} Event
                </div>

                <div class="hero-chip">
                    👥 {{ number_format($totalPeserta,0,',','.') }} Peserta
                </div>

                <div class="hero-chip">
                    💰 {{ number_format($totalTransaksi,0,',','.') }} Transaksi
                </div>

            </div>

            <div class="hero-actions">

                <a href="/event/create"
                class="hero-btn hero-btn-primary">

                    <i class="ti ti-plus"></i>
                    Buat Event

                </a>

                <a href="/search"
                class="hero-btn hero-btn-secondary">

                    <i class="ti ti-compass"></i>
                    Jelajah Event

                </a>

            </div>

        </div>

        <div class="row m-0">

            <div class="col-md-3 col-6 mb-3 p-2">

                <div class="dashboard-stat">

                    <div class="dashboard-icon icon-blue">
                        <i class="fas fa-user-plus"></i>
                    </div>

                    <div class="dashboard-label">
                        Event Diikuti
                    </div>

                    <div class="dashboard-value">
                        {{ number_format($eventDiikuti,0,',','.') }}
                    </div>

                    <div class="dashboard-subtitle">
                        Event yang pernah diikuti
                    </div>

                </div>

            </div>

            <div class="col-md-3 col-6 mb-3 p-2">

                <div class="dashboard-stat">

                    <div class="dashboard-icon icon-red">
                        <i class="fas fa-calendar-check"></i>
                    </div>

                    <div class="dashboard-label">
                        Event Dibuat
                    </div>

                    <div class="dashboard-value">
                        {{ number_format($eventDibuat,0,',','.') }}
                    </div>

                    <div class="dashboard-subtitle">
                        Event yang dikelola
                    </div>

                </div>

            </div>

            <div class="col-md-3 col-6 mb-3 p-2">

                <div class="dashboard-stat">

                    <div class="dashboard-icon icon-green">
                        <i class="fas fa-users"></i>
                    </div>

                    <div class="dashboard-label">
                        Peserta Dijangkau
                    </div>

                    <div class="dashboard-value">
                        {{ number_format($totalPeserta,0,',','.') }}
                    </div>

                    <div class="dashboard-subtitle">
                        Total peserta event
                    </div>

                </div>

            </div>

            <div class="col-md-3 col-6 mb-3 p-2">

                <div class="dashboard-stat">

                    <div class="dashboard-icon icon-purple">
                        <i class="fas fa-wallet"></i>
                    </div>

                    <div class="dashboard-label">
                        Total Transaksi
                    </div>

                    <div class="dashboard-value">
                        {{ number_format($totalTransaksi,0,',','.') }}
                    </div>

                    <div class="dashboard-subtitle">
                        Seluruh transaksi
                    </div>

                </div>

            </div>

        </div>

    </section>

    @if (Session::has('popup'))
        <script type="text/javascript">
            alertify.alert("Sukses!", "{{ session()->get('popup') }}");
        </script>
    @endif
@endsection
