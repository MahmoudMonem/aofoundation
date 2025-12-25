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
        padding: 35px;
    }
    
    .form-group {
        margin-bottom: 22px;
        position: relative;
    }
    
    .form-group label {
        display: block;
        color: #a0a0a0;
        font-size: 12px;
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
        padding: 14px 15px 14px 48px;
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
    
    .password-strength {
        margin-top: 10px;
    }
    
    .strength-bar {
        height: 4px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 2px;
        overflow: hidden;
        margin-bottom: 6px;
    }
    
    .strength-fill {
        height: 100%;
        width: 0%;
        transition: all 0.3s ease;
        border-radius: 2px;
    }
    
    .strength-text {
        font-size: 11px;
        color: #666;
    }
    
    .btn-register {
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
        margin-top: 10px;
    }
    
    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }
    
    .btn-register:active {
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
    
    .terms-text {
        font-size: 12px;
        color: #666;
        text-align: center;
        margin-top: 20px;
        line-height: 1.6;
    }
    
    .terms-text a {
        color: #8b7e71 ;
        text-decoration: none;
    }
    
    .terms-text a:hover {
        text-decoration: underline;
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
    
    /* Row layout for name fields if needed */
    .form-row {
        display: flex;
        gap: 15px;
    }
    
    .form-row .form-group {
        flex: 1;
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
            <h2>{{ __('Create Account') }}</h2>
            <p>{{ __('Join us today') }}</p>
        </div>
        
        <div class="auth-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label for="name">{{ __('Full Name') }}</label>
                    <div class="input-wrapper">
                        <input id="name" 
                               type="text" 
                               class="@error('name') is-invalid @enderror" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Enter your full name"
                               required 
                               autocomplete="name" 
                               autofocus>
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    @error('name')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                
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
                               autocomplete="email">
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
                               placeholder="Create a password"
                               required 
                               autocomplete="new-password">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    <div class="password-strength" id="passwordStrength" style="display: none;">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <span class="strength-text" id="strengthText"></span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    <div class="input-wrapper">
                        <input id="password-confirm" 
                               type="password" 
                               class="" 
                               name="password_confirmation" 
                               placeholder="Confirm your password"
                               required 
                               autocomplete="new-password">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                </div>
                
                <button type="submit" class="btn-register">
                    {{ __('Create Account') }}
                </button>
                
                <p class="terms-text">
                    {{ __('By registering, you agree to our') }} 
                    <a href="#">{{ __('Terms of Service') }}</a> {{ __('and') }} 
                    <a href="#">{{ __('Privacy Policy') }}</a>
                </p>
            </form>
        </div>
        
        <div class="auth-footer">
            <p>{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Sign In') }}</a></p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const strengthContainer = document.getElementById('passwordStrength');
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        
        if (password.length === 0) {
            strengthContainer.style.display = 'none';
            return;
        }
        
        strengthContainer.style.display = 'block';
        
        let strength = 0;
        let text = '';
        let color = '';
        
        // Length check
        if (password.length >= 8) strength += 25;
        if (password.length >= 12) strength += 15;
        
        // Contains lowercase
        if (/[a-z]/.test(password)) strength += 15;
        
        // Contains uppercase
        if (/[A-Z]/.test(password)) strength += 15;
        
        // Contains number
        if (/[0-9]/.test(password)) strength += 15;
        
        // Contains special char
        if (/[^A-Za-z0-9]/.test(password)) strength += 15;
        
        if (strength <= 25) {
            text = 'Weak';
            color = '#e74c3c';
        } else if (strength <= 50) {
            text = 'Fair';
            color = '#f39c12';
        } else if (strength <= 75) {
            text = 'Good';
            color = '#3498db';
        } else {
            text = 'Strong';
            color = '#27ae60';
        }
        
        strengthFill.style.width = Math.min(strength, 100) + '%';
        strengthFill.style.background = color;
        strengthText.textContent = text;
        strengthText.style.color = color;
    });
});
</script>
@endsection