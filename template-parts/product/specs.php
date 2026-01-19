<?php $specs = carbon_get_the_post_meta('technical_specs'); ?>
<?php if ($specs): ?>
<table class="w-full text-sm border border-gray-200">
  <tbody>
    <?php foreach ($specs as $row): ?>
      <tr class="border-b">
        <td class="px-4 py-3 bg-gray-50 w-1/3 font-medium"><?php echo esc_html($row['label']); ?></td>
        <td class="px-4 py-3"><?php echo esc_html($row['spec_value']); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>

