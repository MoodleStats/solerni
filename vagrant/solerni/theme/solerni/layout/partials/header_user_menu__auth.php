<?php

/*
 * @author    Orange / Solerni
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$is_dashboard           = $this->is_menu_item_active( '/my' );
$has_admin_capacity     = has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));

?>

<li class="slrn-top-header__item">
    <a href="<?php echo $CFG->wwwroot; ?>/my">
        <?php echo get_string('dashboard', 'theme_solerni'); ?>
    </a>
    <?php if ( $is_dashboard ) : ?>
        <span class="slrn-topbar-item__active"></span>
    <?php endif; ?>
</li>
<li class="slrn-top-header__item">
    <a class="dropdown-toggle  -not-uppercase" data-toggle="dropdown" role="button">
        <?php echo get_string('hello', 'theme_solerni') . ' ' . $USER->firstname . ' ' . $USER->lastname; ?>
        <b class="caret -is-white"></b>
    </a>
    <ul class="dropdown-menu">
        <span class="slrn-topbar-item__active"></span>
        <li class="dropdown-menu__item">
            <a class="-not-uppercase" href="<?php echo $CFG->wwwroot ?>/user/profile.php">
                <img class="profileicon" src="<?php echo $this->pix_url('profile/profile', 'theme') ?>" />
                <?php echo get_string('viewprofile'); ?>
            </a>
        </li>
        <li class="dropdown-menu__item">
            <a class="-not-uppercase" href="<?php echo $CFG->wwwroot ?>/user/edit.php">
                <img class="profileicon" src="<?php echo $this->pix_url('profile/edit', 'theme') ?>" />
                <?php echo get_string('editmyprofile'); ?>
            </a>
        </li>
        <?php if ( $has_admin_capacity ) : ?>
        <li class="dropdown-menu__item">
            <a class="-not-uppercase" href="<?php echo $CFG->wwwroot ?>/admin/index.php">
                <img class="profileicon" src="<?php echo $this->pix_url('a/settings', 'core') ?>" />
                <?php echo get_string('administration', 'theme_solerni'); ?>
            </a>
        </li>
        <?php endif; ?>
        <li class="dropdown-menu__item">
            <a class="-not-uppercase" href="<?php echo $CFG->wwwroot ?>/user/files.php">
                <img class="profileicon" src="<?php echo $this->pix_url('profile/files', 'theme') ?>" />
                <?php echo get_string('myfiles'); ?>
            </a>
        </li>
        <li class="dropdown-menu__item">
            <a class="-not-uppercase" href="<?php echo $CFG->wwwroot ?>/login/logout.php">
                <img class="profileicon" src="<?php echo $this->pix_url('profile/logout', 'theme') ?>" />
                <?php echo get_string('logout'); ?>
            </a>
        </li>
     </ul>
</li>