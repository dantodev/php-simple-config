<?php namespace Dtkahl\SimpleConfig;

class Config
{

    private $_data = [];
    private $_aliases = [];

    public function __construct(array $data = [], array $alias = [])
    {
        $this->_data = $data;
        $this->_aliases = $alias;
    }

    /**
     * @param string $alias
     * @param string $path
     */
    public function setAlias($alias, $path)
    {
        $this->_aliases[$alias] = $path;
    }

    /**
     * @param string $path
     * @return bool
     */
    public function has($path)
    {
        $keys = $this->_splitPath($path);
        $scope = $this->_getScope($keys);

        return !is_null($scope) && array_key_exists(end($keys), $scope);
    }

    /**
     * @param string $path
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get($path, $default = null)
    {
        $keys = $this->_splitPath($path);
        $scope = $this->_getScope($keys);
        $last = end($keys);

        return !is_null($scope) && array_key_exists($last, $scope) ? $scope[$last] : $default;
    }

    /**
     * @param string $path
     * @param mixed $value
     * @param bool $force
     * @return $this
     */
    public function set($path, $value, $force = false)
    {
        $keys = $this->_splitPath($path);
        $scope = &$this->_getScope($keys, $force);
        $last = end($keys);

        if (!is_null($scope)) {
            $scope[$last] = $value;
        }

        return $this;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function remove($path)
    {
        $keys = $this->_splitPath($path);
        $scope = &$this->_getScope($keys);
        $last = end($keys);

        if (!is_null($scope)) {
            unset($scope[$last]);
        }

        return $this;
    }

    /**
     * @param string $path
     * @return string[]
     */
    private function _splitPath($path)
    {
        $keys = explode('.', $path);

        if (count($keys) > 0 && array_key_exists($keys[0], $this->_aliases)) {
            $keys = array_merge(explode('.', $this->_aliases[array_shift($keys)]), $keys);
        }

        return $keys;
    }

    /**
     * @param string[] $keys
     * @param bool $force
     * @return array|null
     */
    private function &_getScope($keys, $force = true)
    {
        $scope = &$this->_data;

        if (count($keys) > 1) {
            foreach ($keys as $i => $key) {
                if (count($keys) - 1 !== $i) {
                    if (!is_array($scope)) {
                        return null;
                    }
                    if (!array_key_exists($key, $scope)) {
                        if (!$force) {
                            return null;
                        }
                        $scope[$key] = [];
                    }
                    $scope = &$scope[$key];
                }
            }
        }

        return $scope;
    }

}