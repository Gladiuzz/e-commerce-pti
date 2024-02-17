<!-- resources/views/customer/profile.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="profile-header">
            <h1>Profil Pelanggan</h1>
        </div>

        <div class="profile-details">
            <div class="profile-info">
                <div class="profile-info-label">Nama:</div>
                <div class="profile-info-value">{{ $customer->name }}</div>
            </div>

            <div class="profile-info">
                <div class="profile-info-label">Alamat:</div>
                <div class="profile-info-value">{{ $customer->address }}</div>
            </div>

            <div class="profile-info">
                <div class="profile-info-label">Nomor Telepon:</div>
                <div class="profile-info-value">{{ $customer->phone }}</div>
            </div>

            <div class="profile-info">
                <div class="profile-info-label">Alamat Email:</div>
                <div class="profile-info-value">{{ $customer->email }}</div>
            </div>

            <!-- Tambahkan informasi tambahan sesuai kebutuhan -->

            <div class="profile-actions">
                <a href="{{ route('ubah.profil.pelanggan') }}" class="btn btn-primary">Ubah Profil</a>
            </div>
        </div>
    </div>
@endsection
