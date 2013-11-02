<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

namespace Custom\User\Compound;

use Pi;
use Module\User\AbstractCompoundHandler;

/**
 * Custom education handler
 *
 *
 * @author Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 */
class Education extends AbstractCompoundHandler
{
    /** @var string Field name and table name */
    protected $name = 'education';

    /** @var string Form class */
    protected $form = '';

    /** @var string File to form template */
    protected $template = '';

    /** @var string Form filter class */
    protected $filter = '';

}