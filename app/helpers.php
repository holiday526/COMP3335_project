<?php

if (! function_exists('entireGameNextRound')) {
    function entireGameNextRound() {

    }
}

if (! function_exists('responseFormatter')) {
    function responseFormatter($record, $function) {
        switch ($function) {
            case 'index': return response(['records'=>$record], 200); break;
            case 'store': return response(['stored_record'=>$record], 201); break;
            case 'update': return response(['updated_record'=>$record], 202); break;
            case 'delete': return response(['deleted_record_count'=>count($record)], 202); break;
            case 'restore': return response(['restored_record_count'=>count($record)], 202); break;
            case 'boolean': return response(['status'=>$record], 200); break;
        }
    }
}

if (! function_exists('errorResponse')) {
    function errorResponse($error_msgs) {
        return response(['error_message'=>$error_msgs], 400);
    }
}
