@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center gap-4 mb-4">
                <div class="position-relative">
                    <div class="border border-2 border-primary rounded-circle">
                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle m-1" alt="user1"
                            width="60">
                    </div>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">{{ ucwords(implode(', ', auth()->user()->getRoleNames()->toArray())) }}
                    </span>
                </div>
                <div>
                    <h3 class="fw-semibold">Hi, <span class="text-dark">{{ auth()->user()->name }}</span>!
                    </h3>
                    <span>{{ auth()->user()->email }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-cols-md-3 row-cols-2 gx-5 p-5">
        @foreach ($news as $news)
            <div class="col mb-5">
                <div class="card" style="width: 18rem;">
                    <img src="{{ $news->image_url }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $news->title }}</h5>
                        <p class="card-text">{{ $news->description }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


@endsection
