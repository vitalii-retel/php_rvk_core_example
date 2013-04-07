<?php

class FatalErrorEventHandler {

    function __invoke($e) {
        if (Env::isProduction()) {
            echo 'Ups...';
            return false;
        }
    }

}
