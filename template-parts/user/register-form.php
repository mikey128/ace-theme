<?php
$errors = [];
foreach (['error','error_username','error_email','error_password','reason'] as $k) {
  if (isset($_GET[$k])) { $errors[$k] = sanitize_text_field($_GET[$k]); }
}
$prefill_username = isset($_GET['prefill_username']) ? sanitize_text_field($_GET['prefill_username']) : '';
$prefill_email    = isset($_GET['prefill_email']) ? sanitize_email($_GET['prefill_email']) : '';
$action = esc_url(admin_url('admin-post.php'));
$disabled = function_exists('ace_register_enabled') ? !ace_register_enabled() : false;
?>
<section class="max-w-md mx-auto px-6 py-10">
  <h1 class="text-2xl font-semibold text-gray-900 mb-6">Create your account</h1>
  <?php if ($disabled || (isset($errors['error']) && $errors['error'] === 'disabled')): ?>
    <div class="mb-4 rounded-md bg-yellow-50 p-4 text-yellow-800">
      <p class="font-semibold">Registration is currently disabled.</p>
      <ul class="mt-2 list-disc list-inside text-sm">
        <li>Enable “Anyone can register” at Settings → General.</li>
        <li>Enable “Frontend Registration” in Theme Options → User Module Settings.</li>
      </ul>
    </div>
  <?php endif; ?>
  <?php if ($disabled) { return; } ?>
  <form method="post" action="<?php echo $action; ?>" class="space-y-5">
    <input type="hidden" name="action" value="ace_register">
    <?php wp_nonce_field('ace_register'); ?>
    <div>
      <label class="block text-sm font-medium text-gray-700">Username</label>
      <input
        type="text"
        name="username"
        value="<?php echo esc_attr($prefill_username); ?>"
        class="mt-1 block w-full rounded-md border <?php echo isset($errors['error_username']) ? 'border-red-500' : 'border-gray-300'; ?> px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
        <?php echo isset($errors['error_username']) ? 'aria-invalid="true" title="Invalid or already taken"' : ''; ?>
        required
      >
      <?php if (isset($errors['error_username'])): ?>
        <p class="mt-1 text-sm text-red-600">Invalid or already taken.</p>
      <?php endif; ?>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">Email</label>
      <input
        type="email"
        name="email"
        value="<?php echo esc_attr($prefill_email); ?>"
        class="mt-1 block w-full rounded-md border <?php echo isset($errors['error_email']) ? 'border-red-500' : 'border-gray-300'; ?> px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
        <?php echo isset($errors['error_email']) ? 'aria-invalid="true" title="Invalid or already in use"' : ''; ?>
        required
      >
      <?php if (isset($errors['error_email'])): ?>
        <p class="mt-1 text-sm text-red-600">Invalid or already in use.</p>
      <?php endif; ?>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">Password</label>
      <input
        type="password"
        name="password"
        class="mt-1 block w-full rounded-md border <?php echo isset($errors['error_password']) ? 'border-red-500' : 'border-gray-300'; ?> px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
        <?php echo isset($errors['error_password']) ? 'aria-invalid="true" title="At least 8 characters"' : ''; ?>
        required
      >
      <?php if (isset($errors['error_password'])): ?>
        <p class="mt-1 text-sm text-red-600">At least 8 characters.</p>
      <?php endif; ?>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">Company (optional)</label>
      <input type="text" name="company" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">Telephone (optional)</label>
      <input type="text" name="telephone" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">Address (optional)</label>
      <textarea name="address" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600" rows="3"></textarea>
    </div>
    <div>
      <button type="submit" class="inline-flex items-center justify-center rounded-md bg-black px-5 py-2 text-white font-semibold hover:bg-gray-800">Sign up</button>
    </div>
  </form>
</section>
