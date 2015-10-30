
<header id="page-header" class="clearfix">
    <div id="page-navbar" class="clearfix">
        <nav class="breadcrumb-nav" role="navigation" aria-label="breadcrumb"><?php echo $OUTPUT->navbar(); ?></nav>
        <div class="breadcrumb-button"><?php echo $OUTPUT->page_heading_button(); ?></div>
        <?php if ($knownregionpre || $knownregionpost) : ?>
            <div class="breadcrumb-button"> <?php echo $OUTPUT->content_zoom(); ?></div>
        <?php endif; ?>
    </div>
    <div id="course-header">
        <?php echo $OUTPUT->course_header(); ?>
    </div>
</header>
