<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

class TF_SEEK_GOOGLE_MAPS {

    private $cacheFileHandle = false;
    private $cacheFileName   = 'tf_seek_google_maps_markers.json';
    private $cacheFilePath   = null;
    private $infoBoxTemplate = 'infoBox-template.php';

    private $adminNoticeShow = false; // If admin notice was shown

    public function __construct($register_hooks = true){

        $import = (isset($_GET['page']) && $_GET['page'] == 'tf_import') ? true : false;

        if ($register_hooks && !$import){
            add_action('before_delete_post',    array(&$this, 'renew_maps_cache'), 10);
            add_action('save_post',             array(&$this, 'renew_maps_cache'), 10);
            add_action('admin_notices',         array(&$this, 'tf_seek_admin_notice'), 11);

            add_filter('tf_update_nag_notice',  array(&$this, 'filter_tf_update_nag_notice'));
        }

        add_action('tf_ext_import_end', array(&$this, 'renew_maps_cache'), 20);

        $this->cacheFilePath = get_template_directory().'/cache/'.$this->cacheFileName;
    }

    public function __destruct(){
        if($this->cacheFileHandle !== false){
            $this->closeCacheFile();
        }
    }

    public function filter_tf_update_nag_notice($html){
        if($this->cacheFileExistWritable() !== false){
            return $html;
        }

        if($html && !$this->adminNoticeShow){
            $this->adminNoticeShow = true;

            $doc    = new DOMDocument;
            @$doc->loadHTML($html);

            $doc->getElementById('update-nag')->appendChild( new DOMCdataSection( '<div>'.$this->getAdminNoticeText().'</div>' ) );

            return $doc->saveHTML();
        }

        return $html;
    }

    public function tf_seek_admin_notice(){
        if (!empty($_GET['page']) && $_GET['page'] == 'tfupdates')
            return;

        if($this->cacheFileExistWritable() !== false){
            return;
        }

        if(!$this->adminNoticeShow){
            $this->adminNoticeShow = true;

            echo '<div class="update-nag">';
            echo $this->getAdminNoticeText();
            echo '</div>';
        }
    }

    private function getAdminNoticeText(){
        return '<span style="color:#de1d1d;">
            '.sprintf( __('The folder %s needs to have write and execute permisssions. %s', 'tfuse'),
            '<b><i>' . get_template_directory() .'/cache</i></b>',
            '<a href="http://themefuse.com/faq/how-do-i-change-the-write-permissions-for-a-folder/" target="_blank" style="color:#de1d1d;">'.__('Learn out how you could fix that','tfuse').'</a>').'
            </span>';
    }

    /**
     * Checks if a file is writable and tries to make it if not.
     *
     * @return bool true if writable
     */
    function isFileWritable($filename) {
        //can we write?
        if (!is_writable($filename)) {
            //no we can't.
            if (!@chmod($filename, 0666)) {
                $pathtofilename = dirname($filename);
                //Lets check if parent directory is writable.
                if (!is_writable($pathtofilename)) {
                    //it's not writeable too.
                    if (!@chmod($pathtofilename, 0666)) {
                        //darn couldn't fix up parrent directory this hosting is foobar.
                        //Lets error because of the permissions problems.
                        return false;
                    }
                }
            }
        }
        //we can write, return 1/true/happy dance.
        return true;
    }

    private function cacheFileExistWritable(){
        if($this->cacheFileHandle !== false){
            return true;
        }

        if(!file_exists($this->cacheFilePath)){
            if(!($tmp_handle = @fopen($this->cacheFilePath, 'w'))){
                return false;
            }
            fclose($tmp_handle);
        }

        if(!$this->isFileWritable($this->cacheFilePath)){
            return false;
        }

        return true;
    }

    /**
     * Return handle to cache file or FALSE
     */
    private function openCacheFile(){
        if($this->cacheFileHandle !== false){
            return true;
        }

        if(!$this->cacheFileExistWritable()){
            return false;
        }

        $this->cacheFileHandle = fopen($this->cacheFilePath, 'w');

        return true;
    }

    private function writeCacheFile($content){
        if(!$this->openCacheFile()){
            return false;
        } else {
            fwrite($this->cacheFileHandle, $content);
            return true;
        }
    }

    private function closeCacheFile(){
        if($this->cacheFileHandle !== false){
            fclose($this->cacheFileHandle);
            $this->cacheFileHandle = false;
            return true;
        } else {
            return false;
        }
    }

    public function cacheOutput(){
        if(file_exists($this->cacheFilePath)){
            if(false === readfile($this->cacheFilePath)){
                echo '{}';
            }
        } else {
            echo '{}';
        }
    }

    /**
     * Renew google maps cache for seek custom posts (cache containt markers)
     */
    public function renew_maps_cache($post_id){
        // Check type
        $post_type = get_post_type($post_id);
        if($post_type){
            if($post_type != TF_SEEK_HELPER::get_post_type())
                return;

            //verify post is not a revision
            if ( wp_is_post_revision( $post_id ) ) {
                return;
            }
        }

        if(!$this->openCacheFile()){
            return;
        }

        global $wpdb;
        $TFUSE      = get_instance();
        $SEEK       = TF_SEEK_HELPER::get_class_instance();

        $searchable_options = $SEEK->get_just_searchable_options( $TFUSE->get->ext_options('SEEK', TF_SEEK_HELPER::get_post_type()) );

        $sql_select_searchable = '';
        if(sizeof($searchable_options)){
            foreach($searchable_options as $key=>$val){
                $sql_select_searchable .= ',
                options.'.$key;
            }
        }

        $sql = "SELECT
        options.post_id,
        p.post_title
        ".$sql_select_searchable."
            FROM " . TF_SEEK_HELPER::get_db_table_name() . " AS options
        INNER JOIN " . $wpdb->prefix . "posts AS p                      ON p.ID                         = options.post_id
        LEFT  JOIN " . $wpdb->prefix . "term_relationships AS tr        ON tr.object_id                 = options.post_id
        LEFT  JOIN " . $wpdb->prefix . "term_taxonomy AS taxonomy       ON taxonomy.term_taxonomy_id    = tr.term_taxonomy_id
        LEFT  JOIN " . $wpdb->prefix . "terms AS taxonomy_terms         ON taxonomy_terms.term_id       = tr.term_taxonomy_id
            WHERE p.post_status = 'publish'
                AND p.post_type = '". TF_SEEK_HELPER::get_post_type() ."'
                AND options.seek_property_maps_has_position != 0
        GROUP BY p.ID";

        $_result = array();

        $results = $wpdb->get_results($sql, ARRAY_A);
        if(sizeof($results)){
            foreach($results as $result){

                $template_data = array(
                    'post_id'       => $result['post_id'],
                    'post_title'    => $result['post_title'],
                    //'post_thumb'    => tfuse_get_property_thumbnail($result['post_id'])
                    'post_thumb'    => tfuse_page_options('thumbnail_image', get_template_directory_uri() . '/images/dafault_image.jpg', $result['post_id'])
                );
                if(sizeof($searchable_options)){
                    foreach($searchable_options as $key=>$val){
                        $template_data[$key] = $result[$key];
                    }
                }

                $_result[ $result['post_id'] ] = array(
                    'lat'   => doubleval($result['seek_property_maps_lat']),
                    'lng'   => doubleval($result['seek_property_maps_lng']),
                    'html'  => $this->getTemplateHtml($this->infoBoxTemplate, $template_data),
                );
            }
        }
        unset($results);

        $this->writeCacheFile( json_encode($_result) );
        $this->closeCacheFile();
    }

    private function getTemplateHtml($templatePath, $templateData = array()){
        if(sizeof($templateData)){
            foreach ($templateData as $varName => $varValue){
                ${$varName} = $varValue;
            }
        }

        ob_start();
        require($templatePath);
        $buffer = ob_get_clean();

        return $buffer;
    }
}
$tf_seek_google_maps = new TF_SEEK_GOOGLE_MAPS();

/**
 * Ajax action that returns json with markers
 */
function tf_action_ajax_seek_get_google_maps_markers() {
    if( !( isset($_POST['action']) || isset($_POST['tf_action']) )){ // Just to be sure
        die();
    }

    $tmp_tf_seek_google_maps = new TF_SEEK_GOOGLE_MAPS(false);
    $tmp_tf_seek_google_maps->cacheOutput();

    die();
}

/**
 * Ajax action that returns permalink for specie
 */
function tf_action_ajax_seek_get_google_maps_post_permalink() {
    if( !( isset($_POST['action']) || isset($_POST['tf_action']) )){ // Just to be sure
        die();
    }

    $post_id = intval( $_POST['post_id'] );

    echo json_encode(array('permalink'=>get_permalink($post_id)));

    die();
}