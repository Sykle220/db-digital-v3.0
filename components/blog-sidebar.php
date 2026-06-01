<?php
// components/blog-sidebar.php
global $blog_categories, $blog_tags;
?>
<aside class="blog-sidebar">
    <div class="sidebar-search">
        <form action="blog.php" method="GET">
            <input type="text" name="search" placeholder="Search Here . . ." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit"><i class="flaticon-search"></i></button>
        </form>
    </div>
    
    <div class="blog-widget">
        <h4 class="bw-title">Categories</h4>
        <div class="bs-cat-list">
            <ul class="list-wrap">
                <?php foreach ($blog_categories as $cat): ?>
                <li>
                    <a href="blog.php?category=<?php echo urlencode(getCategoryField($cat)); ?>">
                        <?php echo getCategoryField($cat); ?> <span>(<?php echo $cat['count']; ?>)</span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <div class="blog-widget">
        <h4 class="bw-title">Recent Posts</h4>
        <div class="rc-post-wrap">
            <?php 
            $recent_posts = array_slice($GLOBALS['blog_posts'], 0, 4);
            foreach ($recent_posts as $rc): 
            ?>
            <div class="rc-post-item">
                <div class="thumb">
                    <a href="<?php echo $rc['url']; ?>"><img src="<?php echo ASSETS_URL; ?>img/blog/<?php echo $rc['image']; ?>" alt="<?php echo htmlspecialchars(getBlogField($rc, 'title')); ?>"></a>
                </div>
                <div class="content">
                    <span class="date"><i class="far fa-calendar"></i><?php echo $rc['date']; ?></span>
                    <h2 class="title"><a href="<?php echo $rc['url']; ?>"><?php echo htmlspecialchars(getBlogField($rc, 'title')); ?></a></h2>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="blog-widget">
        <h4 class="bw-title">Tags</h4>
        <div class="bs-tag-list">
            <ul class="list-wrap">
                <?php foreach ($blog_tags as $tag): ?>
                <li><a href="blog.php?tag=<?php echo urlencode($tag[$current_lang]); ?>"><?php echo $tag[$current_lang]; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</aside>