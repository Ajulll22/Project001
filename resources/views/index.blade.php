@extends('layouts.master')

@section('title', "Dashboard")

@section('page-script')
    <script>
    </script>
@endsection

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>

  <!-- Content Row -->
  <div class="row">

      <!-- Earnings (Monthly) Card Example -->
      <div class="col mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                  <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                              Peserta Balita</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $balita }}</div>
                      </div>
                      <div class="col-auto">
                          <i class="fas fa-baby fa-2x text-gray-300"></i>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->
      <div class="col mb-4">
          <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                  <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                              Peserta Remaja</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $remaja }}</div>
                      </div>
                      <div class="col-auto">
                          <i class="fas fa-child fa-2x text-gray-300"></i>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->
      <div class="col mb-4">
          <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                  <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Peserta Lansia</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lansia }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-person-booth fa-2x text-gray-300"></i>
                        </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- Pending Requests Card Example -->
  </div>
@endsection