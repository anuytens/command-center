<?php
/**
 * SDIS 62
 *
 * @category   Api
 * @package    Api_Service_IApplication
 */

 /**
 * Interface's Service layer for API Application
 *
 * @category   Api
 * @package    Api_Service_IApplication
 */
interface Api_Service_IApplication
{
    public function getApplication($id_application);
    public function getApplicationByConsumerKey($consumer_key);
}