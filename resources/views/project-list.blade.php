@extends('layouts.app')

@section('css-depends')
    @include('components.css.core')
    @include('components.css.dashboard')
@endsection

@section('js-depends')
    @include('components.js.core')
    @include('components.js.dashboard')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <!-- BEGIN PAGE HEADER-->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ url('/home') }}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="{{ url('/projects') }}">Project</a>
            </li>
        </ul>
        <div class="page-toolbar">
            <button type="button" class="btn btn-fit-height green">
                New Project <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
    @if (session('error'))
        <div class="note note-warning">
            <p>
                {{ session('error') }}
            </p>
        </div>
    @endif
    <h3 class="page-title">
        Project List<small></small>
    </h3>

    <!-- END PAGE HEADER-->
    @if(isset($projects))
    @foreach($projects as $project)
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light">
                <div class="portlet-body">
                    <a href="/projects/{{ $project['id'] }}">
                    <div class="row">
                        <div class="col-md-2">
                            <img class="project-picture" src="{{ ($project['project_picture'].isEmptyOrNullString())?'/img/project-holder.jpg':'/img/projects/pictures/'.$project['project_picture'] }}" class="img-responsive" alt="">
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-12">
                                        <h2 style="margin-top: 0px;">{{ $project['title'] }}</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <p>
                                    <span class="label label-primary">
                                        <i class="fa fa-file-photo-o"></i> {{ $countAll = $project['photos']->count() }}
                                    </span>
                                        <span class="label label-success">
                                        <i class="fa fa-check"></i> {{ $countDone = $project['photos']->where('status','done')->count() }}
                                    </span>
                                        <span class="label label-warning">
                                        <i class="fa fa-times"></i> {{ ($countAll-$countDone) }}
                                    </span>
                                    </p>
                                    <div class="note note-warning">
                                        <p>
                                            Progress bars
                                        </p>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $countDone }}" aria-valuemin="0" aria-valuemax="{{ $countAll }}" style="width: {{ $progressDone = $countDone/(($countAll>0)?$countAll:1)*100 }}%">
                                <span class="sr-only">
                                    40% Complete (success)
                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4>Shared</h4>
                                    <ul class="list-inline">
                                        @foreach($project['members'] as $member)
                                            <li class="tooltips" data-container="body" data-placement="bottom" data-original-title="{{ $member['fullname'] }}">
                                            <span class="photo">
                                                <img  src="{{ "/uploads/avatar/".$member['avatar'] }}" class="img-circle" style="width: 45px; height: 45px;">
                                            </span>
                                            </li>
                                            @if($loop->count == 4)
                                                <li class="tooltips" data-container="body" data-placement="bottom" data-original-title="Others">
                                            <span class="photo">
                                                <img  src="/img/avatar.png" class="img-circle" style="width: 45px; height: 45px;">
                                            </span>
                                                </li>
                                                @break
                                            @endif

                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
@endsection