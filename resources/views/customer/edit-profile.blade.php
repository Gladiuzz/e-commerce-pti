<!-- resources/views/customer/edit-profile.blade.php -->
@extends('layouts.app-user')

@section('content')
    <div class="container-fluid align-items-center justify-content-center mt-5"
        style="background-image: url('/path/to/background-image.jpg'); background-size: cover; background-position: center;">
        @if (session()->has('success'))
            <script>
                window.onload = function() {
                    swal.fire("Data Berhasil Diupdate");
                };
            </script>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12 mt-4">
                <div class="card border-0 shadow rounded">
                    <div class="card-header bg-dark text-white">
                        <center>
                            <i>
                                <h1> Profil Pelanggan</h1>
                            </i>
                        </center>
                    </div>
                    <div class="card-body border border-dark p-5">
                        <form method="POST" action="{{ route('simpan.profil.pelanggan') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">Nama:</label>
                                <input type="text" name="name" id="name" value="{{ $customer->name }}" required
                                    class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="address">Alamat:</label>
                                <input type="text" name="address" id="address" value="{{ $customer->address }}"
                                    required class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="phone">Nomor Telepon:</label>
                                <input type="tel" name="phone" id="phone" value="{{ $customer->phone }}" required
                                    class="form-control">
                            </div>

                            <!-- Tambahkan input untuk atribut lain sesuai kebutuhan -->
                            <center>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </center>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
