@extends('layouts.app')

@section('content')
<body>
<div class="container">
    <input type="hidden" id="user" name="user" value="{{Auth::user()->id}}">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">To-Do List</div>

                <div class="card-body">
                    <div id="app">
                        <to-do></to-do>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@endsection
