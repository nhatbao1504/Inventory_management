@extends('auth.main')

@section('contents')
    <div class="pagetitle">
        <h1>{{ __('messages.order') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">{{ __('messages.order') }}</li>
            </ol>
        </nav>
    </div>

    <div class="row gx-3 my-3">
        <div class="col-md-6 m-0">
            <div class="btn btn-primary me-2">
                <div class="d-flex align-items-center at1">
                    <i class="bi bi-file-earmark-plus pe-2"></i>
                    {{ __('messages.add') }}
                </div>
            </div>
            <div class="btn btn-primary mx-2 btn-export">
                <a href="{{action('App\Http\Controllers\EmployeesController@export')}}" class="d-flex align-items-center text-white">
                    <i class="bi bi-file-earmark-arrow-down pe-2"></i>
                    {{ __('messages.export') }}
                </a>
            </div>
        </div>
    </div>

    <div class="card p-2 rounded-4 border">
        <div class="card-header py-0">
            <div class="card-title my-3 p-0">{{ __('messages.project_list') }}</div>
        </div>
        <div class="card-body">
            <table id="ProjectTable" class="table table-hover table-borderless">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">{{ __('messages.project_code') }}</th>
                        <th class="text-center">{{ __('messages.project_name') }}</th>
                        <th class="text-center">{{ __('messages.status') }}</th>
                        <th class="text-center">{{ __('messages.total_price') }}</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>





@endsection
