@extends('layouts.app')

@section('title', 'Manage User')

@section('css')
@endsection

@section('content')
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Kelola User</h5>
            <div class="ibox-tools">
            </div>
        </div>
        <div class="ibox-content">
            @php
                $segments = explode('/', request()->path());
                $segment = $segments[0];
            @endphp
            <form role="form"
                action="{{ !empty($user) ? url($segment . '/update/' . @$user->id) : url($segment . '/store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" placeholder="Enter Name" value="{{ old('name', @$user->name) }}" name="name"
                        class="form-control" required>
                </div>
                <div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" placeholder="Enter username" value="{{ old('username', @$user->username) }}"
                            name="username" class="form-control" required>
                    </div>
                    <div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" placeholder="Enter email" value="{{ old('email', @$user->email) }}"
                                name="email" class="form-control" required>
                        </div>
                        <div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" placeholder="Enter password" name="password" class="form-control" required>
                            </div>
                            <div>
                                @if (!empty($user))
                                    <input type="hidden" name="role" value="{{ $user->role }}">
                                @endif
                                <div class="mt-3">
                                    <button class="btn btn-sm btn-primary w-100"
                                        type="submit"><strong>Simpan</strong></button>
                                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
@endsection
