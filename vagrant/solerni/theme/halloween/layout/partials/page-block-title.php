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

use local_orange_library\utilities\utilities_course; 
global $COURSE; print_object($COURSE)?>

<!-- page block title -->
<div class="row">
    <div class="col-xs-12 page-block-title">
        <h1><?php echo $titles->pageblocktitleh1; ?></h1>
        <p><?php echo $titles->pageblockdesc; ?></p>
        <div id="navbar">
            <ul class="nav nav-tabs" role="tablist">
                <li><a class="navbar-brand" href="<?php echo utilities_course::get_mooc_learnmore_menu($COURSE->id); ?>">
                    <?php echo "S'INFORMER"?>
                </a></li>        
                <li><a class="navbar-brand" href="<?php echo utilities_course::get_mooc_share_menu(3); ?>">
                    <?php echo "APPRENDRE"?>
                </a></li>        
                <li><a class="navbar-brand" href="<?php echo utilities_course::get_mooc_learnmore_menu(3); ?>">
                    <?php echo "DISCUTER"?>
                </a></li>        
                <li><a class="navbar-brand" href="<?php echo utilities_course::get_mooc_share_menu($COURSE->id); ?>">
                    <?php echo "PARTAGER"?>
                </a></li>        
            </ul>
        </div>
    </div>
</div>


