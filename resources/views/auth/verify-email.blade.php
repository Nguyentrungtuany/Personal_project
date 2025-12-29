@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow">
                <div class="card-header text-center fw-bold">
                    {{ __('Xác minh email') }}
                </div>
                <div class="card-body">

                    <p class="text-muted">
                        {{ __('Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, vui lòng xác minh địa chỉ email của bạn bằng cách nhấp vào liên kết mà chúng tôi vừa gửi qua email. Nếu bạn chưa nhận được email, hãy nhấn nút bên dưới để gửi lại.') }}
                    </p>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success small">
                            {{ __('Một liên kết xác minh mới đã được gửi đến địa chỉ email bạn đã đăng ký.') }}
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        {{-- Resend verification email --}}
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                {{ __('Gửi lại email xác minh') }}
                            </button>
                        </form>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link text-danger">
                                {{ __('Đăng xuất') }}
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
