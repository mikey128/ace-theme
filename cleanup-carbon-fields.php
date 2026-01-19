
<?php
require_once('wp-load.php');

global $wpdb;

// 要删除的字段前缀
$prefixes = [
    '_featured_products_',
    'featured_products_',
    '_featured_message_',
    'featured_message_',
];

echo "开始清理 Carbon Fields 数据...\n";

foreach ($prefixes as $prefix) {
    // 查找所有匹配的 meta_key
    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT meta_id FROM {$wpdb->postmeta} WHERE meta_key LIKE %s",
            $prefix . '%'
        )
    );
    
    $count = count($results);
    echo "找到 {$count} 个以 '{$prefix}' 开头的记录\n";
    
    if ($count > 0) {
        // 批量删除
        $deleted = $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE %s",
                $prefix . '%'
            )
        );
        
        echo "已删除 {$deleted} 条记录\n";
    }
}

echo "清理完成！\n";

// 访问：https://你的网站.com/cleanup-carbon-fields.php
// ⚠️ 执行后立即删除此文件
?>