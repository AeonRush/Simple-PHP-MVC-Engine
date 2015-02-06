<?php

return array(
    /// db connection options
    'db:enabled' => false,
    'db:server' => '127.0.0.1',
    'db:name' => 'db',
    'db:user' => 'root',
    'db:password' => '123321',
    ///
    'auth:session-key'  => 'auth:'.md5('auth-session-key-'.__FILE__),
    /// Engine options
    'eva:languages' => array('ru-RU', 'en-US')
);

/// 2014 | AeonRUSH |