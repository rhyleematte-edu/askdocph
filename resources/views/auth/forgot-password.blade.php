@extends('layouts.app')

@section('title', 'Forgot Password | AskDocPH')

@section('content')
<main class="wrap">
  <section class="left">
    <div class="card">
      <h1>Forgot Password?</h1>
      <p class="subtitle">Enter your email and we'll send you a link to reset your password.</p>

      @if(session('status'))
        <div class="alert success" style="margin-bottom: 20px; padding: 12px; background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #10b981; border-radius: 8px; font-size: 14px;">
            <i data-lucide="check-circle" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 8px;"></i>
            {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}" class="form" novalidate>
        @csrf

        <label>Email Address</label>
        <div class="input-group @error('email') has-error @enderror">
          <i data-lucide="mail"></i>
          <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="you@example.com"
            required
            autocomplete="email"
            autofocus
          />
        </div>
        @error('email')
          <p class="error">{{ $message }}</p>
        @enderror

        <button type="submit" class="btn primary" style="margin-top: 20px;">Send Reset Link</button>
        
        <p class="switch">
          Remembered your password?
          <a href="{{ route('login') }}">Back to Login</a>
        </p>

      </form>
    </div>
  </section>

  <section class="right" style="display: flex; flex-direction: column;">
    <div class="right-content">
      <h2>Expert Guidance for<br>Your Peace of Mind</h2>

      <div class="feature">
        <div class="badge"><i data-lucide="shield-check"></i></div>
        <div>
            <h3>Secure Reset</h3>
            <p>Your security is our priority. We use encrypted tokens for all password resets.</p>
        </div>
      </div>

      <div class="feature">
        <div class="badge"><i data-lucide="clock"></i></div>
        <div>
            <h3>Fast Verification</h3>
            <p>Check your email (including spam) for the reset link within a few minutes.</p>
        </div>
      </div>

      <div style="margin-top:28px; background:rgba(255,255,255,0.12); border-radius:14px; padding:22px; text-align: center; border: 1px solid rgba(255,255,255,0.1);">
          <p style="font-size: 14px; line-height: 1.6; margin: 0;">"Caring for your mental health is a journey. We're here to make every step as smooth as possible."</p>
      </div>
    </div>

    <div style="margin-top: auto; text-align: center; padding-top: 32px;">
        <a href="{{ route('home') }}" style="color: rgba(255,255,255,0.7); text-decoration: none; font-size:13px; display:inline-flex; align-items:center; gap:5px; transition: color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">
          <i data-lucide="arrow-left" style="width:14px;height:14px;"></i> Return to Website
        </a>
    </div>
  </section>
</main>
@endsection
