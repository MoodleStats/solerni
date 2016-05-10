<?php
// This file is part of Moodle - http://moodle.org/
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

/**
 * @package    orange_library
 * @subpackage utilities
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_orange_library\utilities;
use stored_file;

defined('MOODLE_INTERNAL') || die();

class utilities_image {
    /**
     * Get an url to the new image processed depending on the options
     * In case of error, we put an entry on the error_log and send back
     * the original URL of image
     * If the moodle file object is given it is use in priority to access the file
     *
     * @param url or moodle stored_file $image (mandatory)
     *        array $opts (optional)
     *              'scale' => resize image with possible 'deformation'
     *              'crop' => resize image with croping
     *              'output-filename' => keep filename
     *              'w' => new width
     *              'h' => new height
     * @return $newImageUrl
     */
    public static function get_resized_url($image, $opts = null) {
        global $CFG;

        // If image parameter not set then send a default image.
        if (!$image) {
            $image = $CFG->wwwroot . '/theme/halloween/pix/logo-orange.png';
        }

        // If image is a stored_file Moodle, the get Moodle URL.
        if (is_a($image , 'stored_file')) {
            $file = $image;
            if (!$image = self::get_moodle_url_from_stored_file($file)) {
                $image = $CFG->wwwroot . '/theme/halloween/pix/logo-orange.png';
            }
        }

        $imagepath = urldecode($image);
        $purl = parse_url($imagepath);

        // Start configuration.
        $cachefolder = $CFG->solerni_images_directory.'/';
        $remotefolder = $CFG->solerni_original_images_directory.'/';

        $defaults = array('crop' => false, 'scale' => false,
           'canvas-color' => 'transparent', 'output-filename' => false,
           'cacheFolder' => $cachefolder, 'remoteFolder' => $remotefolder, 'quality' => 90, 'cache_http_minutes' => 20);

        $opts = array_merge($defaults, $opts);

        $cachefolder = $opts['cacheFolder'];
        $remotefolder = $opts['remoteFolder'];

        // Update original in cache if needed.
        if (isset($file)) {
            $imagepath = self::update_original_in_cache($file, $remotefolder, $opts['cache_http_minutes']);
        } else if (isset($purl['scheme']) && ($purl['scheme'] == 'http' || $purl['scheme'] == 'https')) {
            $imagepath = self::update_original_in_cache($imagepath, $remotefolder, $opts['cache_http_minutes']);
        }

        // We try to access the image in cache. If an error occurs we return the original url.
        if (file_exists($imagepath) == false) {
            return $image;
        }

        // Get path to resized image.
        $newpath = self::get_image_newpath($imagepath, $cachefolder, $opts);

        // Check that the resize image in cache is not older than original image.
        $create = true;
        if (file_exists($newpath) == true) {
            $create = false;
            $origfiletime = date("YmdHis", filemtime($imagepath));
            $newfiletime = date("YmdHis", filemtime($newpath));
            if ($newfiletime < $origfiletime) { // Not using $opts['expire-time'] .
                $create = true;
            }
        }

        // We have to create the resize image in cache.
        if ($create == true) {
            if (self::resize_from_original($imagepath, $newpath, $opts)) {
                return $CFG->wwwroot . $CFG->solerni_image_base_url . '/' . str_replace($cachefolder, '', $newpath);
            }
            return $image;
        }

        return $CFG->wwwroot . $CFG->solerni_image_base_url . '/' . str_replace($cachefolder, '', $newpath);
    }

    /**
     * Get new image new pathname.
     *
     * @param path to original image $imagepath
     * @param path to cache folder image $newpath
     * @param options $options
     * @return path to image
     */
    private static function get_image_newpath($imagepath, $cachefolder, $options) {
        if (isset($options['w'])) {
            $w = $options['w'];
        }
        if (isset($options['h'])) {
            $h = $options['h'];
        }

        $finfo = pathinfo($imagepath);
        $ext = $finfo['extension'];

        $filename = md5_file($imagepath);

        // If the user has requested an explicit output-filename, do not use the cache directory.
        if (false !== $options['output-filename']) {
            $newpath = $options['output-filename'];
        } else {
            if (!empty($w) and !empty($h)) {
                $newpath = $cachefolder.$filename.'_w'.$w.'_h'.$h.
                        (isset($options['crop']) && $options['crop'] == true ? "_cp" : "").
                        (isset($options['scale']) && $options['scale'] == true ? "_sc" : "").'.'.$ext;
            } else if (!empty($w)) {
                $newpath = $cachefolder.$filename.'_w'.$w.'.'.$ext;
            } else if (!empty($h)) {
                $newpath = $cachefolder.$filename.'_h'.$h.'.'.$ext;
            }
        }

        return $newpath;
    }

    /**
     * Resize Image.
     *
     * @param path to original image $imagepath
     * @param path to new image $newpath
     * @param options $options
     * @return boolean
     */
    private static function resize_from_original($imagepath, $newpath, $options) {

        $pathtoconvert = 'convert'; // This could be something like /usr/bin/convert or /opt/local/share/bin/convert.

        if (isset($options['w'])) {
            $w = $options['w'];
        }
        if (isset($options['h'])) {
            $h = $options['h'];
        }
        if (!empty($w) && !empty($h)) {

            list($width, $height) = getimagesize($imagepath);
            $resize = $w;

            if ($width > $height) {
                $resize = $w;
                if (true === $options['crop']) {
                    $resize = "x".$h;
                }
            } else {
                $resize = "x".$h;
                if (true === $options['crop']) {
                    $resize = $w;
                }
            }

            if (true === $options['scale']) {
                $cmd = $pathtoconvert ." ". escapeshellarg($imagepath) ." -resize ". escapeshellarg($resize) .
                " -quality ". escapeshellarg($options['quality']) . " " . escapeshellarg($newpath);
            } else {
                $cmd = $pathtoconvert." ". escapeshellarg($imagepath) ." -resize ". escapeshellarg($resize) .
                " -size ". escapeshellarg($w ."x". $h) .
                " xc:". escapeshellarg($options['canvas-color']) .
                " +swap -gravity center -composite -quality ". escapeshellarg($options['quality'])." ".escapeshellarg($newpath);
            }

        } else if (!empty($w)) {
            $cmd = $pathtoconvert." " . escapeshellarg($imagepath) .
            " -resize ". $w ."".
            " -quality ". escapeshellarg($options['quality']) ." ". escapeshellarg($newpath);
        } else if (!empty($h)) {
            $cmd = $pathtoconvert." " . escapeshellarg($imagepath) .
            " -resize ". 'x'. $h ."".
            " -quality ". escapeshellarg($options['quality']) ." ". escapeshellarg($newpath);
        }

        $c = exec($cmd, $output, $returncode);

        return ($returncode == 0);
    }

    /**
     * Update image in cache original folder if needed
     *
     * @param url or moodle stored_file $image (mandatory)
     * @param folder of original image $remotefolder
     * @param cache expiration delay in minute $cache_expire_minute
     * @return path to image
     */
    private static function update_original_in_cache($image, $remotefolder, $cacheexpireminute) {
        $downloadimage = true;
        if (is_a($image , 'stored_file')) {
            $localfilepath = $remotefolder.$image->get_filename();
            if (file_exists($localfilepath) && filesize($localfilepath) &&
                ($image->get_timecreated() < strtotime('+'.$cacheexpireminute.' minutes'))) {
                $downloadimage = false;
            }
            if ($downloadimage == true) {
                $image->copy_content_to($localfilepath);
            }
        } else {
            // Grab the image, and cache it so we have something to work with.
            $finfo = pathinfo($image);
            list($filename) = explode('?', $finfo['basename']);
            $localfilepath = $remotefolder.$filename;
            $downloadimage = true;
            if (file_exists($localfilepath) && filesize($localfilepath) &&
                (filemtime($localfilepath) < strtotime('+'.$cacheexpireminute.' minutes'))) {
                $downloadimage = false;
            }
            if ($downloadimage == true) {
                $img = file_get_contents($image);
                file_put_contents($localfilepath, $img);
            }
        }
        return $localfilepath;
    }

    /**
     * Returns the Moodle File Object from Moodle File Storage
     *
     * @param type $context
     * @param type $pluginname
     * @param type $fileareaname
     * @return stored_file object
     */
    public static function get_moodle_stored_file($context, $pluginname, $fileareaname, $itemid = 0) {

        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, $pluginname, $fileareaname, $itemid);
        foreach ($files as $file) {
            if ($file->is_directory()) {
                continue;
            }
            return $file;
        }
    }

    /**
     * Check and returns a moodle url object from Moodle File Storage.
     *
     * @param stored_file $storedfile
     * @return string
     */
    public static function get_moodle_url_from_stored_file($storedfile, $forcedownload = false) {

        if (!is_a($storedfile, 'stored_file') || $storedfile->get_filename() == ".") {
            return false;
        }

        return \moodle_url::make_pluginfile_url(
            $storedfile->get_contextid(),
            $storedfile->get_component(),
            $storedfile->get_filearea(),
            ($storedfile->get_itemid()) ? $storedfile->get_itemid() : null,
            $storedfile->get_filepath(),
            $storedfile->get_filename(),
            $forcedownload
        );
    }
}
