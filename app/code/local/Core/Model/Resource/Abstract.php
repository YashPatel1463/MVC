<?php

class Core_Model_Resource_Abstract
{
    protected $_tablename;
    protected $_primarykey;

    public function __construct()
    {
        $this->_construct();
    }

    public function _construct()
    {
        return $this;
    }

    public function init($tableName, $primaryKey)
    {
        $this->_tablename = $tableName;
        $this->_primarykey = $primaryKey;
    }

    public function getTableName()
    {
        return $this->_tablename;
    }

    public function getAdapter()
    {
        return new Core_Model_DB_Adapter();
    }

    protected function _getDbColumns()
    {
        $sql = "SELECT COLUMN_NAME
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_NAME = N'{$this->_tablename}'";

        return $this->getAdapter()->fetchCol($sql);
    }

    public function load($value, $field = null)
    {
        $field = (is_null($field)) ? $this->_primarykey : $field;
        $sql = "SELECT * FROM `{$this->_tablename}` WHERE {$field} = '{$value}' LIMIT 1";
        return $this->getAdapter()->fetchRow($sql);
    }

    public function save($model)
    {
        $dbcolumns = $this->_getDbColumns();

        //save and update
        $data = $model->getData();
        $primray_id = 0;

        if (isset($data[$this->_primarykey]) && $data[$this->_primarykey]) {
            $primray_id = $data[$this->_primarykey];
        }

        if ($primray_id) {
            $update_data = [];
            unset($data[$this->_primarykey]);

            foreach ($data as $field => $value) {
                if (in_array($field, $dbcolumns)) {
                    $value = ($value != null) ? $value : '';
                    $update_data[] = sprintf("`{$field}` = '%s'", addslashes(trim($value)));
                }
            }

            $update_value = implode(", ", $update_data);

            $sql = sprintf("UPDATE `%s` SET %s WHERE %s=%d ", $this->_tablename, $update_value, $this->_primarykey, $primray_id);

            // echo $sql;
            // die();

            return $this->getAdapter()->query($sql);
        } else {
            $fields = [];
            $values = [];

            foreach ($data as $field => $value) {
                if (in_array($field, $dbcolumns)) {
                    $fields[] = $field;
                    $values[] = sprintf("'%s'", addslashes(trim($value)));
                }
            }

            $field = implode(", ", $fields);
            $value = implode(", ", $values);

            $sql = sprintf("INSERT INTO `%s` (%s) VALUES (%s)", $this->_tablename, $field, $value);

            // echo $sql;
            // die;
            $id =  $this->getAdapter()->insert($sql);

            if ($id) {
                return $model->{$this->_primarykey} = $id;
            } else {
                return false;
            }
        }
        // echo get_class($model);
    }

    public function delete($model)
    {
        $data = $model->getData();

        $sql = sprintf("DELETE FROM `%s` WHERE %s=%d", $this->_tablename, $this->_primarykey, $data[$this->_primarykey]);
        $result = $this->getAdapter()->query($sql);

        if ($result) {
            $model->setData(null);
        } else {
            echo "Data can't Delete";
        }
        return $result;
    }
}
