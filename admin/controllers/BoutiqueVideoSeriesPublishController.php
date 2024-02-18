<?php

class BoutiqueVideoSeriesPublishController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
	
	
	
}
