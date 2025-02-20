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

    public function load($value)
    {
        $this->_data =  $this->getResource()->load($value);
        // echo "<pre>";
        // print_r($this);
        // echo "</pre>";
        return $this;
    }

    public function save()
    {
        $this->getResource()->save($this);
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
        $collection = new $this->_collectionClassName();
        $collection->setResource($this->getResource())
                    ->setModel($this)
                    ->select();
        return $collection;
    }
}
