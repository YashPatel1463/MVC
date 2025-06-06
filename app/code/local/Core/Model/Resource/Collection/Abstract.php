<?php

class Core_Model_Resource_Collection_Abstract
{
    protected $_resource = null;
    protected $_model = null;
    protected $_select = [];

    public function setResource($resource)
    {
        $this->_resource = $resource;
        return $this;
    }

    public function setModel($model)
    {
        $this->_model = $model;
        return $this;
    }

    public function select($columns = ["*"])
    {
        $this->_select['FROM'] = ["main_table" => $this->_resource->getTableName()];
        $this->_select['COLUMNS'] = [];
        $columns = is_array($columns) ? $columns : [$columns];
        foreach ($columns as $alias => $column) {
            // Mage::log($column);
            // Mage::log($alias);
            if(is_int($alias)) {
                $this->_select['COLUMNS'][] = "main_table.".$column;
            }
            else {
                $this->_select['COLUMNS'][] = sprintf("%s AS %s",$column, $alias);
            }
        }
        return $this;
    }

    public function getData()
    {
        // $query = sprintf("SELECT %s FROM %s",implode(", ", $this->_select['COLUMNS']), $this->_select['FROM']);
        // $data = $this->_resource->getAdapter()->fetchAll($query);
        $data = $this->_resource->getAdapter()->fetchAll($this->prepareQuery());

        foreach ($data as &$_data) {
            $model = new $this->_model;
            $_data = $model->setData($_data);
            // print_r($this->_model);
        }

        return $data;
    }

    public function addFieldToFilter($field, $condition)
    {
        if (!is_array($condition)) {
            $condition = ["EQ" => $condition];
        }

        $this->_select["WHERE"][$field][] = $condition;

        return $this;
    }

    public function prepareQuery()
    {
        $query = sprintf("SELECT %s FROM `%s` AS %s", implode(", ", $this->_select['COLUMNS']), $this->getTableName($this->_select['FROM']), $this->getTableAlias($this->_select['FROM']));
        // $query = sprintf("SELECT %s FROM %s AS %s", implode(", ", $this->_select['COLUMNS']), array_values($this->_select['FROM'])[0], array_keys($this->_select['FROM'])[0]);

        if (isset($this->_select['JOIN'])) {
            $joinsql = "";
            foreach ($this->_select["JOIN"] as $join) {
                // $joinsql .= sprintf(" JOIN %s ON %s ", $join['tablename'], $join['condition']);
                $joinsql .= sprintf(" JOIN %s AS %s ON %s ", $this->getTableName($join['tablename']),$this->getTableAlias($join['tablename']),  $join['condition']);
            }
            $query .= " " . $joinsql;
        }

        if (isset($this->_select['LEFT_JOIN'])) {
            $leftjoinsql = "";
            foreach ($this->_select["LEFT_JOIN"] as $leftjoin) {
                $leftjoinsql .= sprintf(" LEFT JOIN %s AS %s ON %s ", $this->getTableName($leftjoin['tablename']),$this->getTableAlias($leftjoin['tablename']),  $leftjoin['condition']);
            }
            $query .= " " . $leftjoinsql;
        }

        if (isset($this->_select['RIGHT_JOIN'])) {
            $rightjoinsql = "";
            foreach ($this->_select["RIGHT_JOIN"] as $rightjoin) {
                $rightjoinsql .= sprintf(" RIGHT JOIN %s ON %s ", $rightjoin['tablename'], $rightjoin['condition']);
            }
            $query .= " " . $rightjoinsql;
        }

        if (isset($this->_select['FULL_JOIN'])) {
            $fulljoinsql = "";
            foreach ($this->_select["FULL_JOIN"] as $fulljoin) {
                $fulljoinsql .= sprintf(" FULL JOIN %s ON %s ", $fulljoin['tablename'], $fulljoin['condition']);
            }
            $query .= " " . $fulljoinsql;
        }

        if (isset($this->_select['WHERE'])) {
            $wheresql = "";
            $count = count($this->_select['WHERE']);
            $condition = [];

            foreach ($this->_select['WHERE'] as $field => $value) {
                foreach ($value as $_value) {
                    $condition[] = $this->where($field, $_value);
                }
            }

            $wheresql .= " WHERE " . implode(" AND ", $condition);
            // die();
            $query .= $wheresql;
        }

        if (isset($this->_select['GROUP_BY'])) {
            $groupby = sprintf(" GROUP BY %s", implode(", ", $this->_select['GROUP_BY']));

            if (isset($this->_select["HAVING"])) {
                $havingsql = "";
                $count = count($this->_select['HAVING']);
                $condition = [];

                foreach ($this->_select['HAVING'] as $field => $value) {
                    foreach ($value as $_value) {
                        $condition[] = $this->where($field, $_value);
                    }
                }

                $havingsql .= " HAVING " . implode(" OR ", $condition);
                // die();
                $groupby .= $havingsql;
            }

            $query .= $groupby;
        }

        if (isset($this->_select['ORDER_BY'])) {
            $orderby = sprintf(" ORDER BY %s", implode(", ", $this->_select['ORDER_BY']));

            $query .= $orderby;
        }

        if (isset($this->_select['LIMIT'])) {
            $limit = sprintf(" LIMIT %s", $this->_select['LIMIT']["limit"]);

            if(!empty($this->_select['LIMIT']["offset"])) {
                $limit .= sprintf(" OFFSET %s", $this->_select['LIMIT']["offset"]);
            }

            $query .= $limit;
        }

        //echo $query;
        // die();
        return $query;
    }

    public function Where($column, $val)
    {
        if (is_array($val)) {
            foreach ($val as $operator => $value) {
                switch (strtoupper($operator)) {
                    case 'IS':
                        $where = " {$column} {$operator} {$value} ";
                        break;

                    case 'IN':
                    case 'NOT IN':
                        if (!is_array($value)) {
                            throw new Exception("Wrong input.");
                        }
                        // print_r($value);
                        $where = " {$column} {$operator} ('" . implode("','", $value) . "') ";
                        // print_r($where);
                        break;

                    case 'NOT BETWEEN':
                    case 'BETWEEN':
                        if (!is_array($value) || count($value) !== 2) {
                            throw new Exception("Wrong input.");
                        }
                        $where = " {$column} {$operator} '{$value[0]}' AND '{$value[1]}' ";
                        break;

                    case 'LIKE':
                    case 'NOT LIKE':
                        $where = " {$column} {$operator} '{$value}' ";
                        break;
                    case 'EQ':
                        $where = " {$column} = '{$value}' ";
                        break;
                    default:
                        $where = " {$column} {$operator} '{$value}' ";
                        break;
                }
            }
        }
        return $where;
    }

    public function join($tableName, $condition, $columns)
    {
        $this->_select["JOIN"][] = ["tablename" => $tableName, "condition" => $condition, "columns" => $columns];

        foreach ($columns as $alias => $columnname) {
            $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s", $this->getTableAlias($tableName), $columnname, $alias);
        }
        return $this;
    }

    public function leftJoin($tableName, $condition, $columns)
    {
        $this->_select["LEFT_JOIN"][] = ["tablename" => $tableName, "condition" => $condition, "columns" => $columns];

        foreach ($columns as $alias => $columnname) {
            $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s", $this->getTableAlias($tableName), $columnname, $alias);
        }
        return $this;
    }

    public function rightJoin($tableName, $condition, $columns)
    {
        $this->_select["RIGHT_JOIN"][] = ["tablename" => $tableName, "condition" => $condition, "columns" => $columns];

        foreach ($columns as $alias => $columnname) {
            $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s", $tableName, $columnname, $alias);
        }
        return $this;
    }

    public function fullJoin($tableName, $condition, $columns)
    {
        $this->_select["FULL_JOIN"][] = ["tablename" => $tableName, "condition" => $condition, "columns" => $columns];

        foreach ($columns as $alias => $columnname) {
            $this->_select['COLUMNS'][] = sprintf("%s.%s AS %s", $tableName, $columnname, $alias);
        }
        return $this;
    }

    public function orderBy($columns)
    {
        if (is_array($columns)) {
            $this->_select["ORDER_BY"] = $columns;
        } else {
            $this->_select["ORDER_BY"] = [$columns];
        }

        return $this;
    }

    public function groupBy($columns)
    {
        if (is_array($columns)) {
            $this->_select["GROUP_BY"] = $columns;
        } else {
            $this->_select["GROUP_BY"] = [$columns];
        }

        return $this;
    }

    public function having($field, $condition)
    {
        if (!is_array($condition)) {
            $condition = ["EQ" => $condition];
        }

        $this->_select["HAVING"][$field][] = $condition;

        return $this;
    }

    public function limit($limit, $offset=0)
    {
        $offset = ($offset) ? ($offset - 1)*$limit : 0;
        $this->_select["LIMIT"] = ["limit" => $limit, "offset"=>$offset];
        return $this;
    }

    private function getTableAlias($table) {
        return array_keys($table)[0];
    }

    private function getTableName($table) {
        return array_values($table)[0];
    }
    
    public function getFirstItem() {
        $data = $this->getData();
        if(isset($data[0])) {
            return $data[0];
        }
        else {
            return $this->_model;
        }
    }
}
