<?php

namespace App\Services;

class AjaxResponse {

    protected function ajaxResponse($code, $message, $data = null)
    {
        $out = [
            "success" => $code,
            "message" => $message,
        ];

        if ($data !== null) {
            $out["result"] = $data;
        }

        return $out;
    }

    public function success($data = null)
    {
        return $this->ajaxResponse(true, '', $data);
    }

    public function fail($message, $extra = [])
    {
        return $this->ajaxResponse(false, $message, $extra);
    }

    public function successJSON($data = null) {
        return json_encode($this->success($data));
    }

    public function failJSON($message, $extra = []) {
        return json_encode($this->fail($message, $extra));
    }
}