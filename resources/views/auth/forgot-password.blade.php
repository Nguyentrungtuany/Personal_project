@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            {{-- Thông báo hướng dẫn --}}
            <div class="alert alert-info text-sm">
                {{ __('Quên mật khẩu? Không sao. Hãy nhập email của bạn, chúng tôi sẽ gửi liên kết để đặt lại mật khẩu.') }}
            </div>

            {{-- Hiển thị trạng thái session --}}
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Form gửi email reset password --}}
            <div class="card">
                <div class="card-header fw-bold text-center">
                    {{ __('Khôi phục mật khẩu') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nút gửi --}}
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Gửi liên kết đặt lại mật khẩu') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
