<?php

class IndexController extends Controller {

    public function index() {
        echo 'Hello world!';
    }

    public function page404($segments) {
        var_export($this->getCore()->getRouteRules()->getRouteUrl()->getSegments());
        echo '<br/>';
        var_export($segments);
        echo '<br/>';
    }

}
