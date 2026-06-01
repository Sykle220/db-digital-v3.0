<?php
// components/project-card.php
// Reçoit un tableau $project
?>
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-10">
    <div class="services-item-three">
        <div class="services-thumb-three">
            <a href="project-details.php?id=<?php echo $project['id']; ?>">
                <img src="<?php echo ASSETS_URL; ?>img/services/<?php echo $project['image']; ?>" alt="<?php echo htmlspecialchars($project['title']); ?>">
            </a>
        </div>
        <div class="services-content-three">
            <div class="services-icon">
                <i class="<?php echo $project['icon']; ?>"></i>
            </div>
            <h4 class="title">
                <a href="project-details.php?id=<?php echo $project['id']; ?>"><?php echo htmlspecialchars($project['title']); ?></a>
            </h4>
            <p><?php echo htmlspecialchars($project['description']); ?></p>
            <div class="overlay-icon">
                <i class="<?php echo $project['icon']; ?>"></i>
            </div>
        </div>
    </div>
</div>