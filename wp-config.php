define( 'WP_HOME', ' define website url' );
define( 'WP_SITEURL', 'define website url' );

ob_start();
error_reporting(0);
ini_set('pcre.recursion_limit',20000000); //for long post
ini_set('pcre.backtrack_limit',10000000); // long post
@ini_set( 'max_input_vars' , 4000 );
define('WP_MEMORY_LIMIT', '768M');
define( 'WP_MAX_MEMORY_LIMIT', '512M' );
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
define('DISALLOW_FILE_EDIT', true);
define( 'CONCATENATE_SCRIPTS', false );
define('FORCE_SSL', true);
define('FORCE_SSL_ADMIN', true);//admin area ssl
define('FORCE_SSL_LOGIN', true);//login area ssl
define( 'EMPTY_TRASH_DAYS',false);
define('WP_POST_REVISIONS', false);
define('FS_CHMOD_FILE', 0644);
define('FS_CHMOD_DIR', 0755);
define( 'COMPRESS_CSS', true );
define( 'COMPRESS_SCRIPTS', true );
define( 'ENFORCE_GZIP', true );
define( 'MEDIA_TRASH', true );
//contact form 7 plugin through  gmail email send 
define( 'SMTP_PORT',   '465' );                  // SMTP port number - likely to be 25, 465 or 587
define( 'SMTP_SECURE', 'tls' );                 // Encryption system to use - ssl or tls
define( 'SMTP_AUTH',    true );                 // Use SMTP authentication (true|false)
define( 'SMTP_DEBUG',   0 );
define( 'SMTP_USER',   'Hotel');    // Username to use for SMTP authentication
define( 'SMTP_PASS',   '1ddrfz& ' );       // Password to use for SMTP authentication
define( 'SMTP_HOST',   'smtp.reiddnas.pk');    // The hostname of the mail server
define( 'SMTP_FROM',   'reinadds@gmail.com' ); // SMTP From email address
define( 'SMTP_NAME',   'e.g Website Name' );    // SMTP From name
define( 'SMTP_PORT',   '587' ,'487');                  // SMTP port number - likely to be 25, 465 or 587
define( 'SMTP_SECURE', 'tls' );                 // Encryption system to use - ssl or tls
define( 'SMTP_AUTH',    true );                 // Use SMTP authentication (true|false)
define( 'SMTP_DEBUG',   0 );    


