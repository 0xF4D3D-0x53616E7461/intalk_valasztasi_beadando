<?php
function send_JSON($input_json){
    header('Content-Type: application/json; charset= utf-8');
    echo json_encode($input_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}