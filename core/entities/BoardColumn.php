<?php

    namespace thebuggenie\core\entities;

    /**
     * Agile board column class
     *
     * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
     * @version 3.1
     * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
     * @package thebuggenie
     * @subpackage main
     */

    /**
     * Agile board column class
     *
     * @package thebuggenie
     * @subpackage main
     *
     * @Table(name="\thebuggenie\core\entities\b2db\BoardColumns")
     */
    class BoardColumn extends \TBGIdentifiableScopedClass
    {

        /**
         * The name of the column
         *
         * @var string
         * @Column(type="string", length=200)
         */
        protected $_name;

        /**
         * Column description
         *
         * @var string
         * @Column(type="string", length=200)
         */
        protected $_description;

        /**
         * @var \thebuggenie\core\entities\AgileBoard
         * @Column(type="integer", length=10)
         * @Relates(class="\thebuggenie\core\entities\AgileBoard")
         */
        protected $_board_id;

        /**
         * @var integer
         * @Column(type="integer", length=10)
         */
        protected $_sort_order;

        /**
         * @var integer
         * @Column(type="integer", length=10)
         */
        protected $_max_workitems;

        /**
         * @var integer
         * @Column(type="integer", length=10)
         */
        protected $_min_workitems;

        /**
         * Associated status ids
         *
         * @var array
         * @Column(type="serializable", length=500)
         */
        protected $_status_ids = null;

        public function getName()
        {
            return $this->_name;
        }

        public function setName($name)
        {
            $this->_name = $name;
        }

        public function getDescription()
        {
            return $this->_description;
        }

        public function hasDescription()
        {
            return (bool) ($this->getDescription() != '');
        }

        public function setDescription($description)
        {
            $this->_description = $description;
        }

        /**
         * Returns the associated project
         *
         * @return \thebuggenie\core\entities\AgileBoard
         */
        public function getBoard()
        {
            return $this->_b2dbLazyload('_board_id');
        }

        public function setBoard($board)
        {
            $this->_board_id = $board;
        }

        function getMaxWorkitems()
        {
            return $this->_max_workitems;
        }

        function getMinWorkitems()
        {
            return $this->_min_workitems;
        }

        function setMaxWorkitems($max_workitems)
        {
            $this->_max_workitems = $max_workitems;
        }

        function setMinWorkitems($min_workitems)
        {
            $this->_min_workitems = $min_workitems;
        }

        public function getSortOrder()
        {
            return $this->_sort_order;
        }

        public function setSortOrder($sort_order)
        {
            $this->_sort_order = $sort_order;
        }

        public function getStatusIds()
        {
            return (is_array($this->_status_ids)) ? $this->_status_ids : array();
        }

        public function hasStatusId($status_id)
        {
            return in_array($status_id, $this->getStatusIds());
        }

        public function hasStatusIds()
        {
            return !empty($this->getStatusIds());
        }

        public function setStatusIds($status_ids)
        {
            $this->_status_ids = $status_ids;
        }

    }
