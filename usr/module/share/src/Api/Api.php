<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

namespace Module\Share\Api;

use Pi;

/**
 * User share APIs
 *
 * @author Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 */
class Share extends AbstractUseApi
{
    /**
     * @{inheritDoc}
     */
    protected $module = 'share';

    /** @var array Available actions */
    protected $actions = array(
        'like',
        'view',
        'rate',
        'share'
    );

    /**
     * Parse root data from URI
     *
     * @param string $uri
     *
     * @return int|array Root id or data for root
     */
    public function parse($uri)
    {
    }

    /**
     * Add an item root
     *
     * @param array $root
     *
     * @return int
     */
    public function add(array $root)
    {
        $row = Pi::model('root', $this->module)->createRow($root);
        $row->save();

        return (int) $row['id'];
    }

    /**
     * Get user contributed data of an item
     *
     * @param int $root
     * @param int $uid
     * @param string[] $actions
     *
     * @return array
     */
    public function get($root, $uid = null, array $actions = array())
    {
        $result = array();
        $uid = $uid ?: Pi::user()->getId();
        $actions = $this->actions($actions);
        $model = Pi::model('action', $this->module);
        $where = array(
            'root'  => $root,
            'uid'   => $uid,
        );
        if ($actions) {
            $where['action'] = $actions;
        }
        $rowset = $model->select($where);
        foreach ($rowset as $row) {
            /*
            $result[$row['action']] = array(
                'value' => $row['value'],
                'time'  => $row['time'],
            );
            */
            $result[$row['action']] = Pi::api($row['action'], $this->module)
                ->buildUserData($row);
        }

        return $result;
    }

    /**
     * Get stats of an item
     *
     * @param int $root
     * @param string[] $actions
     *
     * @return array
     */
    public function stats($root, array $actions = array())
    {
        $result = array();
        $actions = $this->actions($actions);
        $model = Pi::model('stats', $this->module);
        $where = array(
            'root'  => $root,
        );
        if ($actions) {
            $where['action'] = $actions;
        }
        $rowset = $model->select($where);
        foreach ($rowset as $row) {
            /*
            $result[$row['action']] = array(
                'value' => $row['value'],
                'count' => $row['count'],
            );
            */
            $result[$row['action']] = Pi::api($row['action'], $this->module)
                ->buildStatsData($row);
        }

        return $result;
    }
    /**
     * Get user contributed data and stats of an item
     *
     * @param array|string $root
     * @param int $uid
     * @param string[] $actions
     *
     * @return array
     */
    public function load($root, $uid = null, array $actions = array())
    {
        if (is_string($root)) {
            $root = $this->parse($root);
        }
        if (is_array($root)) {
            $root = $this->add($root);
        }

        $data   = $this->get($root, $uid, $actions);
        $stats  = $this->stats($root, $actions);
        $result = array_merge_recursive($data, $stats);

        return $result;
    }

    /**
     * Delete action data and stats data subject of given items
     *
     * @param int|int[] $root
     *
     * @return int
     */
    public function delete($root)
    {
        $modelRoot      = Pi::model('root', $this->module);
        $modelAction    = Pi::model('action', $this->module);
        $modelStats     = Pi::model('stats', $this->module);

        $count  = 0;
        $roots  = (array) $root;
        $count += $modelRoot->delete(array('id' => $roots));
        $modelAction->delete(array('root' => $roots));
        $modelStats->delete(array('root' => $roots));

        return $count;
    }

    /**
     * Get action list
     *
     * @param string[] $actions
     * @param bool $returnLabel
     *
     * @return array
     */
    public function actions(array $actions = array(), $returnLabel = false)
    {
        if (!$actions) {
            $actions = $this->actions;
        } else {
            $actions = array_intersect($this->actions, $actions);
        }
        if (!$returnLabel) {
            $result = $actions;
        } else {
            $actionList = array(
                'like'  => __('Like'),
                'view'  => __('Views'),
                'rate'  => __('Rate'),
                'share' => __('Share'),
            );

            foreach ($actions as $action) {
                if (isset($actionList[$action])) {
                    $result[$action] = $actionList[$action];
                }
            }
        }

        return $result;
    }
}
