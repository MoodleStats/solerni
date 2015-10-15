<?php
use theme_halloween\settings\options;
use theme_halloween\tools\theme_utilities;
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <ul class="list-unstyled list-social" role="navigation">
                <li class="social-item h6 hidden-xs"><?php echo get_string('followus', 'theme_halloween'); ?></li>
                <?php foreach(options::halloween_get_followus_urllist() as $key => $value) :
                    if (theme_utilities::is_theme_settings_exists_and_nonempty($key)) : ?>
                        <li class="social-item">
                            <a href="<?php echo $PAGE->theme->settings->$key; ?>" target="_blank" class="icon-halloween icon-halloween--<?php echo $key; ?>">
                                <?php echo $key; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
