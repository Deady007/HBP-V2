@extends('layouts.app')
@section('plugins.Fullcalendar', true)
@section('content')
    <div class="content-wrapper">
       <section class="content">
      <div class="container-fluid">
        <!-- Overview Cards -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $totalPatients }}</h3>
                <p>Total Patients</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $activeDoctors }}</h3>
                <p>Active Doctors</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-stalker"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $activeNurses }}</h3>
                <p>Active Nurses</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $totalMedicalVisits }}</h3>
                <p>Pending Appointments</p>
              </div>
              <div class="icon">
                <i class="ion ion-calendar"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <!-- /.row -->

        <!-- Appointment Calendar -->
        
        <!-- /.row -->

        <!-- Recent Activities Log -->
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Recent Activities</h3>
              </div>
              <div class="card-body">
                <ul class="list-group">
                  <li class="list-group-item">New patient registration: John Doe</li>
                  <li class="list-group-item">System update: Version 3.2.1</li>
                  <!-- ...additional activities... -->
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->

        <!-- Graphical Reports -->
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Patient Recovery Trends</h3>
              </div>
              <div class="card-body">
                <canvas id="recovery-trends-chart" style="height: 300px;"></canvas>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Appointment Trends</h3>
              </div>
              <div class="card-body">
                <canvas id="appointment-trends-chart" style="height: 300px;"></canvas>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->

        <!-- Medical Visits Count -->
    
        <!-- /.row -->

      </div><!-- /.container-fluid -->
    </section>
    </div>
@endsection
