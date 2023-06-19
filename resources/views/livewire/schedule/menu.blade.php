<div>
@extends('layouts.app')
@section('content')

<div class="card">
        <div class="card-header">
            <b>Schedule</b> | Course Schedule
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-8 text-right">
                    <b>Semester</b>
                </div>
            <div class="row">
                <div class="col-sm-12 ">
                    <x-adminlte-button class="btn-sm" label="All" theme="info"/>
                    <x-adminlte-button class="btn-sm" label="Odd" theme="info"/>
                    <x-adminlte-button class="btn-sm" label="Event" theme="info"/>
                    <x-adminlte-button class="btn-sm" label="Import" theme="success"/>
                </div>
            </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    @livewire('schedule.content')
                </div>
            </div>
                        
        </div>
        <div class="card-footer text-muted">
            @ArSys<i>2023</i>
        </div>
        
    </div>

@endsection

</div>
