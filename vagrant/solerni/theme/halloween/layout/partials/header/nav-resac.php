<?php
// This file is part of The Orange Halloween Moodle Theme
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

use local_orange_library\utilities\utilities_network;

$homeresac = utilities_network::get_home();
$resacs = utilities_network::get_hosts_from_mnethome();
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <nav class="resac-navigation clearfix">
                <ul class="list-group pull-left resac-home">
                    <?php echo $OUTPUT->resac_nav_items($homeresac); ?>
                </ul>
                <ul class="list-group pull-right resac-hosts">
                    <?php echo $OUTPUT->resac_nav_items($resacs, true); ?>
                </ul>
            </nav>
        </div>
    </div>
</div>
