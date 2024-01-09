@extends('layout.app')

@section('content')

<div style="height: 100%" class="container d-flex align-items-center justify-content-center">
        <a style="text-decoration: none;" href="{{ route('web.form') }}">
            <div class="svg-wrapper">
                <svg height="60" width="320" xmlns="http://www.w3.org/2000/svg">
                    <rect class="shape" height="60" width="320" />
                </svg>
                <div class="text">Login</div>
          </div>
        </a>
</div>



@endsection
