<?php

/*
 * @author    Orange / Solerni
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$is_login       = $this->is_menu_item_active( '/login/index.php' );
$is_register    = $this->is_menu_item_active( '/login/signup.php' )

?>

<li class="slrn-top-header__item<?php echo ( $is_login ) ? ' -is-active' : ''; ?>">
    <a href="<?php echo $CFG->wwwroot ?>/login/index.php"><?php echo get_string('login', 'theme_solerni'); ?></a>
    <?php if ( $is_login ) : ?>
        <span class="slrn-topbar-item__active"></span>
    <?php endif; ?>
</li>
<li class="slrn-top-header__item<?php echo ( $is_register ) ? ' -is-active' : ''; ?>">
    <a href="<?php echo $CFG->wwwroot ?>/login/signup.php"><?php echo get_string('register', 'theme_solerni'); ?></a>
    <?php if ( $is_register ) : ?>
        <span class="slrn-topbar-item__active"></span>
    <?php endif; ?>
</li>
