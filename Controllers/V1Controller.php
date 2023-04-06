<?php

class V1Controller extends AController {

    public function process() {
        switch ($this->urlFolder) {

            default:{
                throw new HTTPSpecialCaseException(404);
            }
        }
    }
}
