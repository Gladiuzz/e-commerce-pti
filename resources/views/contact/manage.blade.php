@extends('layouts.app')

@section('title', 'Manage Contact')

@section('css')
@endsection

@section('content')
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Manage Contact</h5>
            <div class="ibox-tools">
            </div>
        </div>
        <div class="ibox-content">
            <form role="form"
                action="{{ !empty($contact) ? url('contact/update/' . @$contact->id) : route('contact.store') }}"
                method="POST">
                @csrf
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" placeholder="Enter address" value="{{ old('address', @$contact->address) }}"
                        name="address" class="form-control">
                </div>
                <div>
                    <div class="form-group">
                        <label>No Telepon</label>
                        <input type="number" placeholder="Enter Phone Number" value="{{ old('phone', @$contact->phone) }}"
                            name="phone" class="form-control">
                    </div>
                    <div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" placeholder="Enter description"
                                value="{{ old('description', @$contact->description) }}" name="description"
                                class="form-control">
                        </div>
                        <div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" placeholder="Enter Mail" value="{{ old('mail', @$contact->mail) }}"
                                    name="mail" class="form-control">
                            </div>
                            <div>
                                <div class="mt-3">
                                    <button class="btn btn-sm btn-primary w-100"
                                        type="submit"><strong>Submit</strong></button>
                                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
@endsection
