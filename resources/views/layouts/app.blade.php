@extends('adminlte::page')

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <!-- FullCalendar CSS -->
<link rel="stylesheet" href="/vendor/fullcalendar/main.min.css" />


@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    <!-- FullCalendar JS -->
     <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

@stop
