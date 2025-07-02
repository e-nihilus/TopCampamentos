<?php

   /************************************************************************
    * REQUIRED
    *
    * Access Key ID and Secret Acess Key ID, obtained from:
    * http://aws.amazon.com
    ***********************************************************************/
    define('AWS_ACCESS_KEY_ID', 'AKIAJU6JLNOJKTPZPNAA');
    define('AWS_SECRET_ACCESS_KEY', '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');

   /************************************************************************
    * REQUIRED
    *
    * All MWS requests must contain a User-Agent header. The application
    * name and version defined below are used in creating this value.
    ***********************************************************************/
    define('APPLICATION_NAME', 'MarktMaat');
    define('APPLICATION_VERSION', '1.0.0');

   /************************************************************************
    * REQUIRED
    *
    * All MWS requests must contain the seller's merchant ID and
    * marketplace ID.
    ***********************************************************************/
    define ('MERCHANT_ID', 'A2LIAVG6WTS5JV');
    define ('MARKETPLACE_ID', 'A1RKKUPIHCS9HS');
    define ('DATE_FORMAT', 'Y-m-d\TH:i:s.00\Z');

   /************************************************************************
    * OPTIONAL ON SOME INSTALLATIONS
    *
    * Set include path to root of library, relative to Samples directory.
    * Only needed when running library from local directory.
    * If library is installed in PHP include path, this is not needed
    ***********************************************************************/
    set_include_path(ADPNSY_PATH . '/mws/.');

   /************************************************************************
    * OPTIONAL ON SOME INSTALLATIONS
    *
    * Autoload function is reponsible for loading classes of the library on demand
    *
    * NOTE: Only one __autoload function is allowed by PHP per each PHP installation,
    * and this function may need to be replaced with individual require_once statements
    * in case where other framework that define an __autoload already loaded.
    *
    * However, since this library follow common naming convention for PHP classes it
    * may be possible to simply re-use an autoload mechanism defined by other frameworks
    * (provided library is installed in the PHP include path), and so classes may just
    * be loaded even when this function is removed
    ***********************************************************************/

    ///Europa api

     spl_autoload_register(function ($className){
        $filePath = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        if(file_exists(ADPNSY_PATH . "/mws/" . $filePath)){
            require_once ADPNSY_PATH . "/mws/" . $filePath;
            return;
        }
    });