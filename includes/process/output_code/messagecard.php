<?php /** @noinspection ALL */?>
<div class="card read-card">
    <div class="card-body">

        <h4 class="card-title"><?= $title ?></h4>
        <hr>

        <?php
        if ($is_member and $lastPost < $msgid)
        {
            echo '<span class = "new-post">NEW</span>';
            $update = true;
        }
        ?>
        
        <span class="post-time">Posted by <?= $username ?> on <?= date($postdate) ?> (Eastern Time)</span>
        <p class="card-text"><?= $post ?></p>

    </div>
</div> 