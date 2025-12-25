@extends('layouts.index')

@section('center')
<style>
    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .auth-card {
        background: rgba(25, 25, 35, 0.95);
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5),
                    0 0 0 1px rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        width: 100%;
        max-width: 420px;
        overflow: hidden;
    }
    
    .auth-header {
        background: linear-gradient(135deg, #8b7e71  0%, #5e2e25 100%);
        padding: 30px;
        text-align: center;
    }
    
    .auth-header h2 {
        color: #fff;
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        letter-spacing: 1px;
    }
    
    .auth-header p {
        color: rgba(255, 255, 255, 0.8);
        margin: 10px 0 0;
        font-size: 14px;
    }
    
    .auth-body {
        padding: 40px 35px;
    }
    
    .form-group {
        margin-bottom: 25px;
        position: relative;
    }
    
    .form-group label {
        display: block;
        color: #a0a0a0;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-group .input-wrapper {
        position: relative;
    }
    
    .form-group .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        font-size: 18px;
        transition: color 0.3s ease;
    }
    
    .form-group input {
        width: 100%;
        padding: 15px 15px 15px 50px;
        background: rgba(255, 255, 255, 0.03);
        border: 2px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        color: #fff;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    
    .form-group input:focus {
        outline: none;
        border-color: #8b7e71 ;
        background: rgba(102, 126, 234, 0.05);
        box-shadow: 0 0 20px rgba(102, 126, 234, 0.15);
    }
    
    .form-group input:focus + .input-icon,
    .form-group input:focus ~ .input-icon {
        color: #8b7e71 ;
    }
    
    .form-group input::placeholder {
        color: #555;
    }
    
    .form-group input.is-invalid {
        border-color: #e74c3c;
    }
    
    .invalid-feedback {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 8px;
        display: block;
    }
    
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .remember-me {
        display: flex;
        align-items: center;
        cursor: pointer;
    }
    
    .remember-me input[type="checkbox"] {
        display: none;
    }
    
    .remember-me .checkmark {
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.15);
        border-radius: 5px;
        margin-right: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .remember-me input[type="checkbox"]:checked + .checkmark {
        background: linear-gradient(135deg, #8b7e71  0%, #5e2e25 100%);
        border-color: transparent;
    }
    
    .remember-me input[type="checkbox"]:checked + .checkmark::after {
        content: '✓';
        color: #fff;
        font-size: 12px;
        font-weight: bold;
    }
    
    .remember-me span {
        color: #888;
        font-size: 14px;
    }
    
    .forgot-link {
        color: #8b7e71 ;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s ease;
    }
    
    .forgot-link:hover {
        color: #5e2e25;
    }
    
    .btn-login {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #8b7e71  0%, #5e2e25 100%);
        border: none;
        border-radius: 12px;
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }
    
    .btn-login:active {
        transform: translateY(0);
    }
    
    .auth-footer {
        text-align: center;
        padding: 25px 35px 35px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .auth-footer p {
        color: #666;
        font-size: 14px;
        margin: 0;
    }
    
    .auth-footer a {
        color: #8b7e71 ;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }
    
    .auth-footer a:hover {
        color: #5e2e25;
    }
    
    /* Floating animation for background */
    .floating-shapes {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
        z-index: -1;
    }
    
    .shape {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        animation: float 20s infinite ease-in-out;
    }
    
    .shape:nth-child(1) {
        width: 300px;
        height: 300px;
        top: 10%;
        left: 10%;
        animation-delay: 0s;
    }
    
    .shape:nth-child(2) {
        width: 200px;
        height: 200px;
        top: 60%;
        right: 10%;
        animation-delay: -5s;
    }
    
    .shape:nth-child(3) {
        width: 150px;
        height: 150px;
        bottom: 10%;
        left: 30%;
        animation-delay: -10s;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-30px) rotate(180deg); }
    }
</style>

<div class="floating-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
</div>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h2>{{ __('Welcome Back') }}</h2>
            <p>{{ __('Sign in to continue') }}</p>
        </div>
        
        <div class="auth-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email">{{ __('Email Address') }}</label>
                    <div class="input-wrapper">
                        <input id="email" 
                               type="email" 
                               class="@error('email') is-invalid @enderror" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Enter your email"
                               required 
                               autocomplete="email" 
                               autofocus>
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <div class="input-wrapper">
                        <input id="password" 
                               type="password" 
                               class="@error('password') is-invalid @enderror" 
                               name="password" 
                               placeholder="Enter your password"
                               required 
                               autocomplete="current-password">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        <span>{{ __('Remember Me') }}</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                </div>
                
                <button type="submit" class="btn-login">
                    {{ __('Sign In') }}
                </button>
            </form>
        </div>
        
        @if (Route::has('register'))
        <div class="auth-footer">
            <p>{{ __("Don't have an account?") }} <a href="{{ route('register') }}">{{ __('Create one') }}</a></p>
        </div>
        @endif
    </div>
</div>
@endsection