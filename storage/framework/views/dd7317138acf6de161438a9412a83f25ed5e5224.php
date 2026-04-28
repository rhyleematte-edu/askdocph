<?php $__env->startSection('title', 'Reset Password | AskDocPH'); ?>

<?php $__env->startSection('content'); ?>
<main class="wrap">
  <section class="left">
    <div class="card">
      <h1>Reset Password</h1>
      <p class="subtitle">Enter your new password below to regain access to your account.</p>

      <form method="POST" action="<?php echo e(route('password.update')); ?>" class="form" novalidate>
        <?php echo csrf_field(); ?>

        <input type="hidden" name="token" value="<?php echo e($token); ?>">

        <label>Email Address</label>
        <div class="input-group <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
          <i data-lucide="mail"></i>
          <input
            type="email"
            name="email"
            value="<?php echo e($email ?? old('email')); ?>"
            placeholder="you@example.com"
            required
            autocomplete="email"
            readonly
          />
        </div>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <p class="error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>New Password</label>
        <div class="input-group <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
          <i data-lucide="lock"></i>
          <input
            type="password"
            name="password"
            id="password"
            placeholder="Min. 8 characters"
            required
            autocomplete="new-password"
            autofocus
          />
          <button type="button" class="toggle" id="togglePass" aria-label="Show password">
            <i data-lucide="eye"></i>
          </button>
        </div>
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <p class="error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>Confirm Password</label>
        <div class="input-group">
          <i data-lucide="shield-check"></i>
          <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            placeholder="Repeat your password"
            required
            autocomplete="new-password"
          />
        </div>

        <button type="submit" class="btn primary" style="margin-top: 24px;">Reset Password</button>

      </form>
    </div>
  </section>

  <section class="right" style="display: flex; flex-direction: column;">
    <div class="right-content">
      <h2>Stay Secure,<br>Stay Connected</h2>

      <div class="feature">
        <div class="badge"><i data-lucide="key-round"></i></div>
        <div>
            <h3>Better Security</h3>
            <p>Make sure your password contains letters, numbers, and symbols for maximum protection.</p>
        </div>
      </div>

      <div class="feature">
        <div class="badge"><i data-lucide="user-check"></i></div>
        <div>
            <h3>Account Access</h3>
            <p>Once reset, you will be redirected to the login page to enter your new credentials.</p>
        </div>
      </div>

      <div style="margin-top:28px; background:rgba(255,255,255,0.12); border-radius:14px; padding:22px; border: 1px solid rgba(255,255,255,0.1);">
          <div style="display: flex; align-items: start; gap: 12px;">
              <i data-lucide="info" style="color: #60a5fa; flex-shrink: 0;"></i>
              <p style="font-size: 13px; line-height: 1.5; margin: 0; color: rgba(255,255,255,0.9);">
                  Need help? If you encounter any issues during the reset process, please contact our community support team at <strong>support@askdocph.com</strong>.
              </p>
          </div>
      </div>
    </div>

    <div style="margin-top: auto; text-align: center; padding-top: 32px;">
        <p style="color: rgba(255,255,255,0.6); font-size: 12px; margin: 0;">&copy; <?php echo e(date('Y')); ?> AskDocPH. Secure Access Point.</p>
    </div>
  </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('togglePass');
        const passInput = document.getElementById('password');
        const passConfirm = document.getElementById('password_confirmation');
        
        if (toggleBtn && passInput) {
            toggleBtn.addEventListener('click', () => {
                const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passInput.setAttribute('type', type);
                passConfirm.setAttribute('type', type);
                
                const icon = toggleBtn.querySelector('i');
                if (type === 'text') {
                    icon.setAttribute('data-lucide', 'eye-off');
                } else {
                    icon.setAttribute('data-lucide', 'eye');
                }
                lucide.createIcons();
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\websystem\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>