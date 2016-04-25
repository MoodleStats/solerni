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
     * @param url $image (mandatory)
     *        array $opts (optional)
     *              'scale' => resize image with possible 'deformation'
     *              'crop' => resize image with croping
     *              'output-filename' => keep filename
     *              'w' => new width
     *              'h' => new height
     *        moodle file object $file (optional)
     * @return $newImageUrl
     */
    public static function get_resized_url($image = null, $opts = null, $file = null) {

        global $CFG;

        if (!$image && !$file) {
            return false;
        }

        if ((!$image && $file) && !$image = self::get_moodle_url_from_stored_file($file)) {
            return false;
        }

        $imagepath = urldecode($image);

        // Start configuration.
        $cachefolder = $CFG->solerni_images_directory.'/';
        $remotefolder = $CFG->solerni_original_images_directory.'/';

        $defaults = array('crop' => false, 'scale' => false,
           'canvas-color' => 'transparent', 'output-filename' => false,
           'cacheFolder' => $cachefolder, 'remoteFolder' => $remotefolder, 'quality' => 90, 'cache_http_minutes' => 20);

        $opts = array_merge($defaults, $opts);

        $cachefolder = $opts['cacheFolder'];
        $remotefolder = $opts['remoteFolder'];

        $pathtoconvert = 'convert'; // This could be something like /usr/bin/convert or /opt/local/share/bin/convert.

        // You shouldn't need to configure anything else beyond this point.

        $purl = parse_url($imagepath);
        $finfo = pathinfo($imagepath);
        $ext = $finfo['extension'];

        // Check for remote image.
        // First try to use the moodle file object.
        if ($file) {
            $downloadimage = true;
            $localfilepath = $remotefolder.$file->get_filename();
            if (file_exists($localfilepath) && filesize($localfilepath)) {
                if ($file->get_timecreated() < strtotime('+'.$opts['cache_http_minutes'].' minutes')) {
                    $downloadimage = false;
                }
            }
            if ($downloadimage == true) {
                $file->copy_content_to($localfilepath);
            }
            $imagepath = $localfilepath;
        } else if (isset($purl['scheme']) && ($purl['scheme'] == 'http' || $purl['scheme'] == 'https')) {
            // Grab the image, and cache it so we have something to work with.
            list($filename) = explode('?', $finfo['basename']);
            $localfilepath = $remotefolder.$filename;
            $downloadimage = true;
            if (file_exists($localfilepath) && filesize($localfilepath)) {
                if (filemtime($localfilepath) < strtotime('+'.$opts['cache_http_minutes'].' minutes')) {
                    $downloadimage = false;
                }
            }
            if ($downloadimage == true) {
                $img = file_get_contents($imagepath);
                file_put_contents($localfilepath, $img);
            }
            $imagepath = $localfilepath;
        }

        // We try to access the image. If an error occurs we return the original url.
        if (file_exists($imagepath) == false) {
            return $image;
        }

        if (isset($opts['w'])) {
            $w = $opts['w'];
        }
        if (isset($opts['h'])) {
            $h = $opts['h'];
        }

        $filename = md5_file($imagepath);

        // If the user has requested an explicit output-filename, do not use the cache directory.
        if (false !== $opts['output-filename']) {
            $newpath = $opts['output-filename'];
        } else {
            if (!empty($w) and !empty($h)) {
                $newpath = $cachefolder.$filename.'_w'.$w.'_h'.$h.
                        (isset($opts['crop']) && $opts['crop'] == true ? "_cp" : "").
                        (isset($opts['scale']) && $opts['scale'] == true ? "_sc" : "").'.'.$ext;
            } else if (!empty($w)) {
                $newpath = $cachefolder.$filename.'_w'.$w.'.'.$ext;
            } else if (!empty($h)) {
                $newpath = $cachefolder.$filename.'_h'.$h.'.'.$ext;
            }
        }

        $create = true;
        if (file_exists($newpath) == true) {
            $create = false;
            $origfiletime = date("YmdHis", filemtime($imagepath));
            $newfiletime = date("YmdHis", filemtime($newpath));
            if ($newfiletime < $origfiletime) { // Not using $opts['expire-time'] .
                $create = true;
            }
        }

        if ($create == true) {
            if (!empty($w) && !empty($h)) {

                list($width, $height) = getimagesize($imagepath);
                $resize = $w;

                if ($width > $height) {
                    $resize = $w;
                    if (true === $opts['crop']) {
                        $resize = "x".$h;
                    }
                } else {
                    $resize = "x".$h;
                    if (true === $opts['crop']) {
                        $resize = $w;
                    }
                }

                if (true === $opts['scale']) {
                    $cmd = $pathtoconvert ." ". escapeshellarg($imagepath) ." -resize ". escapeshellarg($resize) .
                    " -quality ". escapeshellarg($opts['quality']) . " " . escapeshellarg($newpath);
                } else {
                    $cmd = $pathtoconvert." ". escapeshellarg($imagepath) ." -resize ". escapeshellarg($resize) .
                    " -size ". escapeshellarg($w ."x". $h) .
                    " xc:". escapeshellarg($opts['canvas-color']) .
                    " +swap -gravity center -composite -quality ". escapeshellarg($opts['quality'])." ".escapeshellarg($newpath);
                }

            } else if (!empty($w)) {
                $cmd = $pathtoconvert." " . escapeshellarg($imagepath) .
                " -resize ". $w ."".
                " -quality ". escapeshellarg($opts['quality']) ." ". escapeshellarg($newpath);
            } else if (!empty($h)) {
                $cmd = $pathtoconvert." " . escapeshellarg($imagepath) .
                " -resize ". 'x'. $h ."".
                " -quality ". escapeshellarg($opts['quality']) ." ". escapeshellarg($newpath);
            }

            $c = exec($cmd, $output, $returncode);
            if ($returncode != 0) {
                return $image;
            }
        }

        // Return cache file path.
        return $CFG->wwwroot . $CFG->solerni_image_base_url . '/' . str_replace($cachefolder, '', $newpath);
    }

    /**
     * Returns the Moodle File Object from Moodle File Storage
     *
     * @param type $context
     * @param type $pluginname
     * @param type $fileareaname
     * @return stored_file object
     */
    public static function get_moodle_stored_file($context, $pluginname, $fileareaname) {

        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, $pluginname, $fileareaname);

        return array_pop($files);
    }

    /**
     * Returns a moodle url object from Moodle File Storage
     *
     * @param stored_file $storedfile
     * @return moodle_url
     */
    public static function get_moodle_url_from_stored_file($storedfile) {

        if (!is_a($storedfile, 'stored_file')) {
            return false;
        }

        if ($storedfile->get_filename() == ".") {
            return false;
        }

        $url = \moodle_url::make_pluginfile_url(
            $storedfile->get_contextid(),
            $storedfile->get_component(),
            $storedfile->get_filearea(),
            $storedfile->get_itemid(),
            $storedfile->get_filepath(),
            $storedfile->get_filename()
        );

        return $url;
    }

}
