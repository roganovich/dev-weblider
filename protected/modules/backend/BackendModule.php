<?php

class BackendModule extends CWebModule {
    public function init() {
        $this->setImport(array(
            'backend.components.*',
        ));
    }
}
