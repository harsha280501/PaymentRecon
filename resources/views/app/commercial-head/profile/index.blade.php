@extends('layouts.commertial-head')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
    </div>
    <div style="height: 70vh;">
        <div style="height: 100%;">
            <section style="display: flex; justify-content: center; align-items: center; height: 100%; ">
                <form id="logout-form" action="{{ url('/') }}/chead/changepwd" method="POST" style="width: 30%">
                    @csrf
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-direction: column; gap: 1em; width: 100%">
                        <div style="border: 2px solid lightgray; padding: 2em; width: 100%; gap: 1em; display: flex; flex-direction: column;">

                            <h3 style="color: #000; margin-bottom: 1em">Change Password</h3>

                            @if ($errors->any())

                            @foreach ($errors->all() as $error)
                            <div class="alert alert-warning" style="font-size: 15px;font-weight: bold; width: 100%">{{$error}}</div>
                            @endforeach
                            @endif

                            @if (session('message'))
                            <h5 class="alert alert-success mb-2" style="width: 100%">{{ session('message') }}</h5>
                            @endif

                            <div class="w-100">
                                <label for="" style="color: #000">Old Password</label>
                                <input type="password" name="oldpassword" class="form-control @error('oldpassword') is-invalid @enderror rounded" id="oldpassword" placeholder="Old Password" value="{{ old('oldpassword') }}" required>
                            </div>

                            <div class="w-100">
                                <label for="" style="color: #000">New Password</label>
                                <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="New Password" value="{{ old('password') }}" required>
                            </div>

                            <div class="w-100" style="color: #000">
                                <label for="">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Confirm Password" value="{{ old('password_confirmation') }}" required>
                            </div>


                            <div class="w-100">
                                <input type="submit" name="Submit" style="width: 100%" class="btn btn-success green" value="Submit">
                            </div>
                        </div>
                    </div>

                </form>
            </section>
        </div>
    </div>

</div>


@endsection
