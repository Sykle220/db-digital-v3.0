<?php
// components/blog-card.php
// Reçoit un tableau $post
?>
<div class="col-md-6">
    <div class="blog-post-item-two">
        <div class="blog-post-thumb-two">
            <a href="<?php echo $post['url']; ?>"><img src="<?php echo ASSETS_URL; ?>img/blog/<?php echo $post['image']; ?>" alt="<?php echo htmlspecialchars(getBlogField($post, 'title')); ?>"></a>
            <a href="blog.php?category=<?php echo urlencode(getBlogField($post, 'category')); ?>" class="tag tag-two"><?php echo getBlogField($post, 'category'); ?></a>
        </div>
        <div class="blog-post-content-two">
            <h2 class="title"><a href="<?php echo $post['url']; ?>"><?php echo htmlspecialchars(getBlogField($post, 'title')); ?></a></h2>
            <p><?php echo htmlspecialchars(getBlogField($post, 'excerpt')); ?></p>
            <div class="blog-meta">
                <ul class="list-wrap">
                    <li>
                        <a href="<?php echo $post['url']; ?>"><img src="<?php echo ASSETS_URL; ?>img/blog/<?php echo $post['avatar']; ?>" alt="<?php echo htmlspecialchars($post['author']); ?>"><?php echo htmlspecialchars($post['author']); ?></a>
                    </li>
                    <li><i class="far fa-calendar"></i><?php echo $post['date']; ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>