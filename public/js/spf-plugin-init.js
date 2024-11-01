/**
* Load more post function 
*/
function spf_loadMoreFeeds(social_space_around_images) {

    /**
    * Get nextpage attribute of load more button 
    */
    var spf_next_page_url = jQuery(".spf-load-more button").attr('nextpage');

    /**
     * Ajax for load more post 
     */
    jQuery.ajax({
        /**
         * we don't need to specify parameters for this request - everything is in URL already
         */
        url: spf_next_page_url,       
        dataType: 'jsonp',
        type: 'GET',
        success: function(social_new_data) {

            for (social_post in social_new_data.data) {

                /**
                 * Get new post data 
                 */
                social_img_standard_resolution = social_new_data.data[social_post].media_url;
                social_img_post_link = social_new_data.data[social_post].permalink;

                /**
                 * Add html for new post data
                 */
                var social_append_html = "<li style='padding : " + social_space_around_images + "px;'><a href='" + social_img_post_link + "' target='_blank'><img src='" + social_img_standard_resolution + "'></a></li>";

                /**
                 * Append in existing html 
                 */
                jQuery(".spf-feed-group").append(social_append_html);
            }

            /**
             * Check isemptyobject of pagination 
             */            
            if (social_new_data.paging.next === undefined) {                
                /**
                 * Hide load more button when pagination object empty 
                 */
                jQuery('.spf-load-more').remove();

            } else {

                /**
                 * Update nextpage attribute of load more button 
                 */
                jQuery(".spf-load-more button").attr('nextpage', social_new_data.paging.next);
            }
        },

        error: function(social_post_error) {

            /**
             * Display error 
             */
            console.log(social_post_error);
        }
    });
}