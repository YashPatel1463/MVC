<?php

class Core_Model_Abstract
{
    protected $_resourceClassName;
    protected $_collectionClassName;

    protected $_data = null;

    public function init() {}

    public function __construct()
    {
        $this->init();
    }

    public function getResource()
    {
        // MAge::log($this->_resourceClassName);
        return new $this->_resourceClassName;
    }

    public function __get($name)
    {
        return isset($this->_data[$name]) ? $this->_data[$name] : "";
    }

    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    public function setData($data)
    {
        $this->_data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->_data;
    }

    public function __call($method, $args)
    {
        $f = substr($method, 0, 3);
        if ($f == 'get' && (strpos($method, '_') === false)) {
            $value = substr($method, 3);
            $field = $this->camelToSnake($value);

            return isset($this->_data[$field]) ? $this->_data[$field] : "";
        } else if ($f == 'set') {
            $value = substr($method, 3);
            $field = $this->camelToSnake($value);

            $this->_data[$field] = $args[0];

            return $this;
        }
        throw new Exception('invalid method');
    }

    public function camelToSnake($input)
    {
        $snakeCase = preg_replace_callback(
            '/[A-Z]/',
            function ($matches) {
                return '_' . strtolower($matches[0]);
            },
            $input
        );

        // Remove the leading underscore if it exists and return the result
        return ltrim($snakeCase, '_');
    }

    public function load($value, $field=null)
    {
        $this->_data =  $this->getResource()->load($value, $field);
        // echo "<pre>";
        // print_r($this);  
        // echo "</pre>";
        $this->_afterLoad();
        return $this;
    }

    public function save()
    {
        $this->_beforeSave();
        $this->getResource()->save($this);
        $this->_afterSave();
        return $this;
    }

    protected function _beforeSave() {
        return $this;
    }

    protected function _afterSave() {
        return $this;
    }

    public function delete()
    {
        $result = $this->getResource()->delete($this);
        if ($result) {
            return $this;
        } else {
            return false;
        }
    }

    public function getCollection()
    {
        // echo $this->__collectionClassName;
        $collection = new $this->_collectionClassName();
        $collection->setResource($this->getResource())
                    ->setModel($this)
                    ->select();
        return $collection;
    }

    protected function _afterLoad() {
        return $this;
    }
}
