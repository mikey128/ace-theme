<?php
if (!is_user_logged_in()) { return; }
$u = wp_get_current_user();
$logout_url = esc_url( admin_url('admin-post.php?action=ace_logout&_wpnonce=' . wp_create_nonce('ace_logout')) );
?>
<section class="max-w-3xl mx-auto px-6 py-10">
  <header class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-900">My Account</h1>
    <p class="mt-2 text-gray-600">Welcome, <?php echo esc_html($u->display_name ?: $u->user_login); ?></p>
  </header>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="rounded-lg border border-gray-200 p-5">
      <h2 class="text-lg font-semibold text-gray-900 mb-3">Profile</h2>
      <dl class="space-y-2 text-gray-800">
        <div><dt class="font-medium">Username</dt><dd><?php echo esc_html($u->user_login); ?></dd></div>
        <div><dt class="font-medium">Email</dt><dd><?php echo esc_html($u->user_email); ?></dd></div>
        <div><dt class="font-medium">Company</dt><dd><?php echo esc_html(get_user_meta($u->ID, 'company', true)); ?></dd></div>
        <div><dt class="font-medium">Telephone</dt><dd><?php echo esc_html(get_user_meta($u->ID, 'telephone', true)); ?></dd></div>
        <div><dt class="font-medium">Address</dt><dd><?php echo nl2br(esc_html(get_user_meta($u->ID, 'address', true))); ?></dd></div>
      </dl>
    </div>
    <div class="rounded-lg border border-gray-200 p-5">
      <h2 class="text-lg font-semibold text-gray-900 mb-3">Actions</h2>
      <a href="<?php echo $logout_url; ?>" class="inline-flex items-center justify-center rounded-md bg-black px-5 py-2 text-white font-semibold hover:bg-gray-800">Logout</a>
    </div>
  </div>
</section>

