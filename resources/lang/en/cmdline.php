<?php
/**
 * Contains the Translations used by command line commands.
 * 
 * PHP Version 7.1
 * 
 * @category HttpRouteController
 * @package  Photogallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     https://github.com/stobbsm/photogallery
 */

return [
    // Scanning
    'title_scan' => "Scan the photogallery to build the database",
    'status_scan_start' => "Scanning the photo library...",
    'status_scan_stop' => "Done scanning the photo library",
    'status_scan_diff' => "Difference in files",
    'scanerror' => "Scanning error :message",
    'status_scan_filenotexist' => "File doesn't exist in the database",

    // Verifying
    'title_verify' => "Verify database integrity",
    'status_verify_start' => "Verifying files in database...",
    'status_verify_stop' => "Done verifying files in database",
    'status_verify_file' => "Checking file: :filename",
    'error_verify_file' => "Error when verifying file",
    'verify_file' => "Verify: :filename",

    // General
    'error_gallerypath' => "You must set GALLERYPATH in your env",
    'error' => "Error running this command",
    'status_adding' => "Adding new files to database",
    'hashof' => "Hash of file",
    'checked' => "Checked",
    'updatedb' => "Update Database",
    'cancel' => "Cancelled",
    'exists' => "Exists",
    'added' => "Added",
    'emptydb' => "Database is empty",
    'nofix' => 'Not attempting to fix. Set autofix to "true" to fix',
];
