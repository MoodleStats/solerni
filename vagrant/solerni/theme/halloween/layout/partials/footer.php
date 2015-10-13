<?php
use theme_halloween\settings\options;
use \local_orange_library\utilities\utilities_user;
use theme_halloween\tools\theme_utilities;
$filter_multilang =  new filter_multilang($PAGE->context, array());
?>

<footer class="footer row u-inverse" role="contentinfo">
    <div class="col-xs-12">
        <ul class="list-unstyled list-social" role="navigation">
            <li class="social-item h6 hidden-xs"><?php echo get_string('followus', 'theme_halloween'); ?></li>
            <?php foreach( options::halloween_get_followus_urllist() as $key => $value ) :
                if (theme_utilities::is_theme_settings_exists_and_nonempty($key)) : ?>
                    <li class="social-item">
                        <a href="<?php echo $PAGE->theme->settings->$key; ?>" class="icon-halloween icon-halloween--<?php echo $key; ?>">
                            <?php echo $key; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="col-xs-12 fullwidth-line"></div>
    <div class="col-xs-12 col-md-4">
    <?php if(theme_utilities::is_theme_settings_exists_and_nonempty(array('footerbrandtitle', 'footerbrandchapo', 'footerbrandarticle', 'footerbrandanchor', 'footerbrandurl'), 'atleastone')) : ?>
        <article class="default-article footer-article">
            <?php if (theme_utilities::is_theme_settings_exists_and_nonempty('footerbrandtitle')) : ?><h2><?php echo $filter_multilang->filter($PAGE->theme->settings->footerbrandtitle); ?></h2><?php endif; ?>
            <?php if (theme_utilities::is_theme_settings_exists_and_nonempty('footerbrandchapo')) : ?><p class="lead"><?php echo $filter_multilang->filter($PAGE->theme->settings->footerbrandchapo); ?></p><?php endif; ?>
            <?php if (theme_utilities::is_theme_settings_exists_and_nonempty('footerbrandarticle')) : ?><p><?php echo $filter_multilang->filter($PAGE->theme->settings->footerbrandarticle); ?></p><?php endif; ?>
            <?php if (theme_utilities::is_theme_settings_exists_and_nonempty(array('footerbrandanchor', 'footerbrandurl'), 'all')) : ?><a href="<?php echo $filter_multilang->filter($PAGE->theme->settings->footerbrandurl); ?>"><?php echo $filter_multilang->filter($PAGE->theme->settings->footerbrandanchor); ?></a><?php endif; ?>
        </article>
    <?php endif; ?>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="col-xs-12 col-md-6"></div>
        <div class="col-xs-12 col-md-6">
            <ul class="list-unstyled list-link" role="navigation">
               <li class="link-item h6"><?php if (theme_utilities::is_theme_settings_exists_and_nonempty('footerlistscolumn1title')) { echo $filter_multilang->filter($PAGE->theme->settings->footerlistscolumn1title); } ?></li>
                <?php if (theme_utilities::is_theme_settings_exists_and_nonempty(array('footerlistscolumn1anchor1', 'footerlistscolumn1link1'), 'all')) : ?><li class="link-item"><a href="<?php echo $PAGE->theme->settings->footerlistscolumn1link1; ?>"><?php echo $filter_multilang->filter($PAGE->theme->settings->footerlistscolumn1anchor1); ?></a></li><?php endif; ?>
                <?php if (theme_utilities::is_theme_settings_exists_and_nonempty(array('footerlistscolumn1anchor2', 'footerlistscolumn1link2'), 'all')) : ?><li class="link-item"><a href="<?php echo $PAGE->theme->settings->footerlistscolumn1link2; ?>"><?php echo $filter_multilang->filter($PAGE->theme->settings->footerlistscolumn1anchor2); ?></a></li><?php endif; ?>
                <?php if (theme_utilities::is_theme_settings_exists_and_nonempty(array('footerlistscolumn1anchor3', 'footerlistscolumn1link3'), 'all')) : ?><li class="link-item"><a href="<?php echo $PAGE->theme->settings->footerlistscolumn1link3; ?>"><?php echo $filter_multilang->filter($PAGE->theme->settings->footerlistscolumn1anchor3); ?></a></li><?php endif; ?>
                <?php if (theme_utilities::is_theme_settings_exists_and_nonempty(array('footerlistscolumn1anchor4', 'footerlistscolumn1link4'), 'all')) : ?><li class="link-item"><a href="<?php echo $PAGE->theme->settings->footerlistscolumn1link4; ?>"><?php echo $filter_multilang->filter($PAGE->theme->settings->footerlistscolumn1anchor4); ?></a></li><?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="col-xs-12 col-md-6">
            <ul class="list-unstyled list-link" role="navigation">
                <li class="link-item h6"><?php if (theme_utilities::is_theme_settings_exists_and_nonempty('footerlistscolumn2title')) { echo $filter_multilang->filter($PAGE->theme->settings->footerlistscolumn2title); } ?></li>
                <?php if (theme_utilities::is_theme_settings_exists_and_nonempty(array('footerlistscolumn2anchor1', 'footerlistscolumn2link1'), 'all')) : ?><li class="link-item"><a href="<?php echo $PAGE->theme->settings->footerlistscolumn2link1; ?>"><?php echo $filter_multilang->filter($PAGE->theme->settings->footerlistscolumn2anchor1); ?></a></li><?php endif; ?>
                <?php if (theme_utilities::is_theme_settings_exists_and_nonempty(array('footerlistscolumn2anchor2', 'footerlistscolumn2link2'), 'all')) : ?><li class="link-item"><a href="<?php echo $PAGE->theme->settings->footerlistscolumn2link2; ?>"><?php echo $filter_multilang->filter($PAGE->theme->settings->footerlistscolumn2anchor2); ?></a></li><?php endif; ?>
                <?php if (theme_utilities::is_theme_settings_exists_and_nonempty(array('footerlistscolumn2anchor3', 'footerlistscolumn2link3'), 'all')) : ?><li class="link-item"><a href="<?php echo $PAGE->theme->settings->footerlistscolumn2link3; ?>"><?php echo $filter_multilang->filter($PAGE->theme->settings->footerlistscolumn2anchor3); ?></a></li><?php endif; ?>
                <?php if (theme_utilities::is_theme_settings_exists_and_nonempty(array('footerlistscolumn2anchor4', 'footerlistscolumn2link4'), 'all')) : ?><li class="link-item"><a href="<?php echo $PAGE->theme->settings->footerlistscolumn2link4; ?>"><?php echo $filter_multilang->filter($PAGE->theme->settings->footerlistscolumn2anchor4); ?></a></li><?php endif; ?>
            </ul>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="list-unstyled list-link">
                <div class="link-item h6"><?php echo get_string('international', 'theme_halloween'); ?></div>
                <?php echo $OUTPUT->halloween_lang_menu(); ?>
            </div>
        </div>
    </div>
</footer>
<?php // Moodle legacy footer
if (utilities_user::is_user_site_admin($USER)) : ?>
    <div class="row text-center u-inverse">
        <span><i>Moodle footer (admins only)</i></span>
        <div id="course-footer"><?php echo $OUTPUT->course_footer(); ?></div>
        <?php
        echo $OUTPUT->login_info();
        echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        ?>
    </div>
<?php endif;
