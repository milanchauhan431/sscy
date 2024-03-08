<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
|| Android Firebase Push Notification Configurations
|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
 */

/*
|--------------------------------------------------------------------------
| Firebase API Key
|--------------------------------------------------------------------------
|
| The secret key for Firebase API
|
 */
//Nativebit
$config['key'] = 'AAAAJCVOrWw:APA91bH5BC2yjmURyJN8I5vQx14RfpWnoI1S7QFsQNwnDFfvU4XaahPrnm3rok01RpG1-X47hGl_WThJrYhLxx-k1wHP9f4LGKOyR8OVSMisrhDYtNXkPyj-zIKi9P2Dm2LJMAG1ihxP';

/*
|--------------------------------------------------------------------------
| Firebase Cloud Messaging API URL
|--------------------------------------------------------------------------
|
| The URL for Firebase Cloud Messafing
|
 */

$config['fcm_url'] = 'https://fcm.googleapis.com/fcm/send';
