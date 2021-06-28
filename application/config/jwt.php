<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * ------------------------------------------------------------------------
 * Json Web Token
 * ------------------------------------------------------------------------
 * This file specifies the configuration necessary to use JWT on the system.
 * 
 * here the encryption key is defined: 
 *		$config['jwt_key'] = 'example_key';
 *
 * and the expiration time of the token
 * 		$config['expiration_time']  = strtotime("+7 day");
 * 
 * Later this information will be used in the library in charge of managing 
 * the authentication.
 * 
 * 		application/libraries/Authorization.php
 * 
 * 
 * for more information about jwt you can visit
 * 		https://github.com/firebase/php-jwt
 */
$config['jwt_key'] = 'jWnZr4u7x!A%D*G-KaNdRgUkXp2s5v8yQeThWmZq4t7w!z%C*F-JaNcRfUjXn2r5+KbPeShVmYq3t6w9z$C&F)J@NcQfTjWnD(G-KaPdSgVkYp3s6v9y$B&E)H@MbQeT!A%D*G-JaNdRgUkXp2s5v8y/B?E(H+Mb';

$config['expiration_time'] = strtotime("+7 day");
