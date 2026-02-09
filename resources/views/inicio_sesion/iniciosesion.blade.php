@extends('layouts.app')

@section('title', 'Login')

@section('content')
<style>
  :root { --auth-primary-color: #0d6efd; }
  .auth-bg {
    min-height: 100vh;
    background: radial-gradient(1200px 600px at -10% -10%, rgba(14,165,233,.12), transparent 60%),
                radial-gradient(1200px 600px at 110% 110%, rgba(168,85,247,.12), transparent 60%),
                linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
  }
  .auth-card {
    background-color: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
  }
  .auth-brand {
    display: flex; flex-direction: column; align-items: center; text-align: center;
    gap: 1rem; margin-bottom: 2rem;
  }
  .auth-badge {
    display: flex; align-items: center; justify-content: center; width: 56px; height: 56px;
    background-color: var(--auth-primary-color); color: #ffffff; border-radius: 12px;
    font-size: 1.25rem; font-weight: 600;
  }
  .auth-title { font-size: 1.75rem; font-weight: 600; margin-bottom: 0.25rem; color: #111827; }
  .auth-subtitle { font-size: 1rem; color: #6b7280; }
  .form-control, .input-group .btn {
    border-radius: 8px; padding-top: 0.85rem; padding-bottom: 0.85rem; border-color: #cbd5e1;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }
  .form-control:focus { border-color: var(--auth-primary-color); box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15); }
  .input-group .form-control { border-top-right-radius: 0; border-bottom-right-radius: 0; }
  .input-group .btn { border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: 0; }
  .btn-primary {
    background-color: var(--auth-primary-color); border-color: var(--auth-primary-color);
    border-radius: 8px; padding: 0.85rem 1rem; font-weight: 600;
  }
  .btn-primary:hover { background-color: #0b5ed7; border-color: #0b5ed7; }
  .hr-soft { border: 0; height: 1px; background-image: linear-gradient(to right, transparent, rgba(0, 0, 0, 0.1), transparent); margin: 2rem 0; }
</style>

<div class="auth-bg d-flex justify-content-center align-items-start">
  <div class="container py-5" style="padding-top: 5rem;">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-5">
        <div class="auth-card p-4 p-md-5">

          <!-- Cabecera -->
          <div class="auth-brand">
            <div class="auth-badge">IN</div>
            <div>
              <h3 class="auth-title">Iniciar Sesión</h3>
              <div class="auth-subtitle">Bienvenido de vuelta</div>
            </div>
          </div>

          <!-- ========================================== -->
          <!--    BLOQUE DE ALERTAS DE SESIÓN (NUEVO)     -->
          <!-- ========================================== -->
          @if (session('error'))
              <div class="alert alert-danger text-center mb-4">
                  <i class="bi bi-exclamation-circle-fill me-1"></i> 
                  {{ session('error') }}
              </div>
          @endif

          @if (session('success'))
              <div class="alert alert-success text-center mb-4">
                  {{ session('success') }}
              </div>
          @endif
          <!-- ========================================== -->

          <form method="POST" action="{{ route('login.submit') }}" id="loginForm" novalidate>
            @csrf

            <!-- Errores de validación de campos -->
            @error('email') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            @error('password') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror

            <div class="mb-3">  
              <label for="email" class="form-label fw-medium">Correo electrónico</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="usuario@ejemplo.com" required autofocus>
            </div>

            <div class="mb-2">
              <label for="password" class="form-label fw-medium">Contraseña</label>
              <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                <button class="btn btn-outline-secondary" type="button" id="togglePass" aria-label="Mostrar u ocultar contraseña">
                  <span id="eyeLabel">Mostrar</span>
                </button>
              </div>
            </div>

            <br>

            <button type="submit" class="btn btn-primary w-100" id="submitBtn">Ingresar</button>
            <hr class="hr-soft">
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  (function () {
    const pass = document.getElementById('password');
    const btn = document.getElementById('togglePass');
    const label = document.getElementById('eyeLabel');
    btn?.addEventListener('click', () => {
      const isText = pass.type === 'text';
      pass.type = isText ? 'password' : 'text';
      label.textContent = isText ? 'Mostrar' : 'Ocultar';
      pass.focus();
    });
    const form = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    form?.addEventListener('submit', () => {
      submitBtn.disabled = true;
      submitBtn.innerText = 'Ingresando…';
    });
  })();
</script>
@endpush
@endsection