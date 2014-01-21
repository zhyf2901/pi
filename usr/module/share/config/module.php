<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link         http://code.pialog.org for the Pi Engine source repository
 * @copyright    Copyright (c) Pi Engine http://pialog.org
 * @license      http://pialog.org/license.txt New BSD License
 */

return array(
    'meta'         => array(
        'title'         => _a('Share'),
        'description'   => _a('Interaction between users and contents.'),
        'version'       => '1.0.0',
        'license'       => 'New BSD',
        'logo'          => 'image/logo.png',
        'icon'          => 'fa fa-thumbs-o-up'
    ),
    'author'        => array(
        'Name'      => 'Taiwen Jiang',
        'Email'     => 'taiwenjiang@tsinghua.org.cn',
        'Website'   => 'http://pialog.org',
    ),
    'resource'      => array(
        'database'      => array(
            'sqlfile'      => 'sql/mysql.sql',
        ),
        'config'        => 'config.php',
    ),
);
