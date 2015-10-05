<?php use theme_halloween\settings\options; ?>

<footer class="footer row u-inverse " role="contentinfo">
    <div class="col-xs-12">
        <ul class="list-unstyled list-social" role="navigation">
            <li class="social-item h6"><?php echo get_string('followus', 'theme_halloween'); ?></li>
            <?php foreach( options::halloween_get_followus_list() as $key => $value ) :
                $url = ( $PAGE->theme->settings->$key ) ? $PAGE->theme->settings->$key : '';
                if ( $url ) : ?>
                    <li class="social-item">
                        <a href="<?php echo $url; ?>" class="icon-halloween icon-halloween--<?php echo $key; ?>">
                            <?php echo $key; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="col-xs-12 fullwidth-line">
    </div>
    <div class="col-xs-12 col-md-4">
        <ul class="list-unstyled list-text">
            <h2>Heading</h2>
    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <li class="link-item"><a href="#">Item 4</a></li>
        </ul>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="col-xs-12 col-md-6"></div>
        <div class="col-xs-12 col-md-6">
            <ul class="list-unstyled list-link" role="navigation">
                <li class="link-item h6">Title</li>
                <li class="link-item"><a href="#">Item 1</a></li>
                <li class="link-item"><a href="#">Item 2</a></li>
                <li class="link-item"><a href="#">Item 3</a></li>
                <li class="link-item"><a href="#">Item 4</a></li>
            </ul>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="col-xs-12 col-md-6">
            <ul class="list-unstyled list-link" role="navigation">
                <li class="link-item h6">Title</li>
                <li class="link-item"><a href="#">Item 1</a></li>
                <li class="link-item"><a href="#">Item 2</a></li>
                <li class="link-item"><a href="#">Item 3</a></li>
                <li class="link-item"><a href="#">Item 4</a></li>
            </ul>
        </div>
        <div class="col-xs-12 col-md-6">
            <ul class="list-unstyled list-link">
                <li class="link-item h6">Title</li>
    <div class="dropdown">
        <button id="dLabel" class="btn btn-primary " type="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
                Button primary
                <span class="caret"></span>
        </button>
        <ul class="dropdown-menu list-unstyled list-link" aria-labelledby="dLabel">
            <li><a href="#">Item 1</a></li>
            <li><a href="#">Item 2</a></li>
            <li><a href="#">Item 3</a></li>
        </ul>
    </div>

    <script>
        $( document ).ready(function() {
            $('.dropdown-toggle').dropdown();
        });
    </script>
            </ul>
        </div>
    </div>
</footer>

<?php // Moodle legacy footer
if (\local_orange_library\utilities\utilities_user::is_user_site_admin($USER)) : ?>
    <div class="row text-center u-inverse">
        <span><i>Ce footer spécifique Moodle n'est visible qu'aux administateurs</i></span>
        <div id="course-footer"><?php echo $OUTPUT->course_footer(); ?></div>
        <?php
        echo $OUTPUT->login_info();
        echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        ?>
    </div>
<?php endif;
