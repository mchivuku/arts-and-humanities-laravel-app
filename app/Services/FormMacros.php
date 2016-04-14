<?php
/**
 * Created by PhpStorm.
 * User: mchivuku
 * Date: 4/14/16
 * Time: 10:25 AM
 */

namespace ArtsAndHumanities\Services;

use Collective\Html\FormBuilder;

class FormMacros extends FormBuilder {

    public function __construct( $html,  $url,  $view, $csrfToken)
    {
        parent::__construct($html, $url, $view, $csrfToken);
    }
}