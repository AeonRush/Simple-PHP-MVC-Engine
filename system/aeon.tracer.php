<?php
# TODO Finalize the tracer
# TODO Дописать tracer
/*
 * В зависимости от уровня ошибки, возможно отправлять email?
 */

function error_handler($code, $message, $file, $line)
{
    if (error_reporting() == 0) return;
    throw new ErrorException($message, 0, $code, $file, $line);
};
function exception_handler($e)
{
    # file_put_contents(__ROOT__.'/1.log',"\nНеперехватываемое исключение: ".$e->getMessage());
};

set_error_handler('error_handler');
set_exception_handler('exception_handler');

/// 2014 | AeonRUSH |