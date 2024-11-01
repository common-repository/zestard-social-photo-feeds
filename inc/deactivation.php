<?php
/**
 * Deactivation 
 */
function SPF_Deactivate() {
    /**
     * flush rewrite rules 
     */
    flush_rewrite_rules();
}
