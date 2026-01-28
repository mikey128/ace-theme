<?php
require_once '../../../wp-load.php';

echo "Checking Product CPT...\n";
if (post_type_exists('product')) {
    echo "Post type 'product' exists.\n";
} else {
    echo "Post type 'product' DOES NOT exist.\n";
}

echo "Checking Product Category Taxonomy...\n";
if (taxonomy_exists('product_category')) {
    echo "Taxonomy 'product_category' exists.\n";
} else {
    echo "Taxonomy 'product_category' DOES NOT exist.\n";
}

$args = [
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 10,
];

echo "Running WP_Query...\n";
$q = new WP_Query($args);

echo "Found " . $q->found_posts . " products.\n";

if ($q->have_posts()) {
    while ($q->have_posts()) {
        $q->the_post();
        echo "- [" . get_the_ID() . "] " . get_the_title() . "\n";
    }
} else {
    echo "No products found in query.\n";
}

// Check terms
$terms = get_terms([
    'taxonomy' => 'product_category',
    'hide_empty' => false,
]);
if (is_wp_error($terms)) {
    echo "Error getting terms: " . $terms->get_error_message() . "\n";
} else {
    echo "Found " . count($terms) . " product categories.\n";
    foreach ($terms as $term) {
        echo "- " . $term->name . " (" . $term->count . ")\n";
    }
}
