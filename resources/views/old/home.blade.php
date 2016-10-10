@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if(Entrust::hasRole('admin'))
                        You are logged in!
                    @else
                        You're admin

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
