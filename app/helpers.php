<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 02.04.17
 * Time: 17:19
 */

function set_active($path, $active = 'active') {

    return Request::is($path) ? $active : '';
}