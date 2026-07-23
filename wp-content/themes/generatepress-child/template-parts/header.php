<?php
//  виводимо хедер
$header_page_id = 1291; 

$post = get_post($header_page_id);

if ($post) {
    echo apply_filters('the_content', $post->post_content);
}
