<?php
$errors = [];
foreach (['error','error_username','error_password'] as $k) {
  if (isset($_GET[$k])) { $errors[$k] = sanitize_text_field($_GET[$k]); }
}
$redirect_to = isset($_GET['redirect_to']) ? wp_validate_redirect($_GET['redirect_to'], '') : '';
$action = esc_url(admin_url('admin-post.php'));
?>
<section class="max-w-md mx-auto px-6 py-10">
  <h1 class="text-2xl font-semibold text-gray-900 mb-6">Sign in</h1>
  <?php if (!empty($errors)): ?>
    <div class="mb-4 rounded-md bg-red-50 p-4 text-red-700">Authentication failed. Please check your credentials.</div>
  <?php endif; ?>
  <form method="post" action="<?php echo $action; ?>" class="space-y-5">
    <input type="hidden" name="action" value="ace_login">
    <?php if ($redirect_to): ?>
      <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>">
    <?php endif; ?>
    <?php wp_nonce_field('ace_login'); ?>
    <div>
      <label class="block text-sm font-medium text-gray-700">Username or Email</label>
      <input type="text" name="username" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600" required>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">Password</label>
      <input type="password" name="password" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600" required>
    </div>
    <div class="flex items-center">
      <input id="remember" type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600">
      <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
    </div>
    <div>
      <button type="submit" class="inline-flex items-center justify-center rounded-md bg-black px-5 py-2 text-white font-semibold hover:bg-gray-800">Sign in</button>
    </div>
  </form>
</section>

