<?php

use local_orange_library\utilities\utilities_object;
use local_orange_library\utilities\utilities_user;

$onthematicfrontpage = true;
$nbusersconnected = utilities_user::get_nbconnectedusers();
$nbusersregistred = utilities_user::get_nbusers();
?>

<div class="row">
    <div class="col-xs-12 page-block-title">
        <div class='page-block-lineinfo-thematic-frontpage'>
            <?php echo get_string('lineinfobegin', 'theme_halloween'); ?>
            <span class='text-bold text-secondary'>
                <?php echo $nbusersregistred; ?>
            </span>
            <?php echo utilities_object::get_string_plural($nbusersregistred, 'theme_halloween', 'registered', 'registeredplural'); ?>
            <span class='text-bold text-secondary'>
                <?php echo $nbusersconnected; ?>
            </span>
            <?php echo utilities_object::get_string_plural($nbusersconnected, 'theme_halloween', 'connected', 'connectedplural'); ?>
        </div>
    </div>
</div>
