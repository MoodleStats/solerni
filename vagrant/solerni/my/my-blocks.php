<?php

    function insert_orange_action_block() {
        $blockname = 'orange_action';

        // Do not try to add the block if we cannot find the default my_pages entry.
        // Private => 1 refers to MY_PAGE_PRIVATE.
        if ($systempage = $DB->get_record('my_pages', array('userid' => null, 'private' => 1))) {
            $page = new moodle_page();
            $page->set_context(context_system::instance());

            // Check to see if this block is already on the default /my page.
            $criteria = array(
                'blockname' => $blockname,
                'parentcontextid' => $page->context->id,
                'pagetypepattern' => 'mydashboard',
                'subpagepattern' => $systempage->id,
            );

            if (!$DB->record_exists('block_instances', $criteria)) {
                // Add the block to the default /my.
                $page->blocks->add_region(BLOCK_POS_RIGHT);
                $page->blocks->add_block($blockname, BLOCK_POS_RIGHT, 0, false, 'mydashboard', $systempage->id);
            }
        }
    }

