<?php

namespace YamlEditor;

/**
 * Class YamlParser
 * This class parse yaml array to php array and vice versa
 */
abstract class YamlParser
{
    const TAB = '  '; // 2 spaces

    /**
     * Parse a yaml array to a php array
     * @param string $content
     * @return array
     */
    public static function toArray($content)
    {
        $result = [];

        $contentLines = explode("\n", $content);

        $nbTabP = 0;
        $list = array();
        $path = '';
        $i = 0;
        while ($line = $contentLines[$i]) {
            $nbTab = self::countTabulations($line);
            //var_dump($path);

            if ($nbTab == $nbTabP) {
                if (self::isListElement($line)) {
                    array_push($list, self::getValue($line));
                } else {
                    if (count($list) > 0) {
                        $result = self::set($path, $list, $result);
                        $list = array();
                    }

                    $name = self::getName($line);
                    $path = self::removeLastPath($path);
                    $path .= strlen($path) > 0 ? ".$name" : $name;
                    if (self::containValue($line)) {
                        $value = self::getValue($line);
                        $result = self::set($path, $value, $result);
                    }
                }
            } elseif ($nbTab > $nbTabP) {
                if (count($list) > 0) {
                    $result = self::set($path, $list, $result);
                    $list = array();
                }

                if (self::isListElement($line)) {
                    array_push($list, self::getValue($line));
                } else {
                    $name = self::getName($line);
                    $path .= strlen($path) > 0 ? ".$name" : $name;
                    if (self::containValue($line)) {
                        $value = self::getValue($line);
                        $result = self::set($path, $value, $result);
                    }
                }
            } else { // $nbTab < $nbTabP
                if (count($list) > 0) {
                    $result = self::set($path, $list, $result);
                    $list = array();
                }

                $n = $nbTabP - $nbTab;
                $path = self::removeLastPath($path, $n + 1);
                if (self::isListElement($line)) {
                    array_push($list, self::getValue($line));
                } else {
                    if (self::isValue($line)) {
                        $value = self::getValue($line);
                        $result = self::set($path, $value, $result);
                    } else {
                        $name = self::getName($line);
                        $path .= strlen($path) > 0 ? ".$name" : $name;
                        if (self::containValue($line)) {
                            $value = self::getValue($line);
                            $result = self::set($path, $value, $result);
                        }
                    }
                }
            }

            $nbTabP = $nbTab;
            $i++;
        }

        if (count($list) > 0) {
            $result = self::set($path, $list, $result);
        }

        return $result;
    }

    /**
     * Parse a php array to a yaml array
     * @param YamlArray $yamlArray
     * @return string
     * @see YamlArray
     */
    public static function toYaml(YamlArray $yamlArray)
    {
        $array = $yamlArray->getArray();

        return self::arrayToYaml($array, 0);
    }

    // _.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-.

    /**
     * @param string $path
     * @param mixed $value
     * @param array $array
     * @return array
     */
    private static function set($path, $value, array $array)
    {
        return self::getArray(explode('.', $path), $value, $array);
    }

    /**
     * @param array $path
     * @param $value
     * @return array
     */
    private static function setArray(array $path, $value)
    {
        if (count($path) == 1) {
            $result[$path[0]] = $value;
        } elseif (count($path) > 1) {
            $result[$path[0]] = self::setArray(array_slice($path, 1), $value);
        } else { // count($path) == 0
            $result = [$value];
        }

        return $result;
    }

    /**
     * @param array $path
     * @param $value
     * @param $array
     * @return array
     */
    public static function getArray(array $path, $value, $array)
    {
        if (count($path) == 1) {
            $array[$path[0]] = $value;
        } elseif (count($path) > 1) {
            if (isset($array[$path[0]])) {
                $array[$path[0]] = self::getArray(array_slice($path, 1), $value, $array[$path[0]]);
            } else {
                $array = array_merge($array, self::setArray($path, $value));
            }
        }

        return $array;
    }

    // _.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-.

    /**
     * @param string $line
     * @return string
     */
    private static function getName($line)
    {
        $l = trim($line);

        if (!self::isListElement($l) && !self::isValue($l)) {
            $t = explode(':', $l);
            return count($t) > 0 ? $t[0] : '';
        } else {
            return '';
        }
    }

    /**
     * @param string $line
     * @return bool|int|float|string
     */
    private static function getValue($line)
    {
        $l = trim($line);

        if (self::containValue($l)) {
            if (self::isValue($l)) {
                if (self::isListElement($l)) {
                    $l = substr($l, 1);
                }
            } else {
                $t = explode(':', $l);
                $l = implode(':', array_slice($t, 1));
            }
            $l = trim($l);

            if (self::isString($l)) {
                $l = substr($l, 1, strlen($l) - 2);
            }

            if (is_numeric($l)) {
                if (is_int($l)) {
                    $l = intval($l);
                } else {
                    $l = floatval($l);
                }
            } elseif (is_bool($l)) {
                $l = boolval($l);
            }

            return $l;
        } else {
            return '';
        }
    }

    /**
     * @param string $line
     * @return bool
     */
    private static function isValue($line)
    {
        return !strstr($line, ':');
    }

    /**
     * @param string $line
     * @return bool
     */
    private static function isListElement($line)
    {
        $l = trim($line);
        return self::isValue($l) && strlen($l) > 0 ? $l[0] == '-' : false;
    }

    /**
     * @param string $line
     * @return bool
     */
    private static function isString($line)
    {
        $l = trim($line);
        $len = strlen($l);
        return $len >= 2 ? $l[0] == '"' && $l[$len - 1] == '"'
            : false;
    }

    // _.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-.

    /**
     * @param string $path
     * @param int $n
     * @return string
     */
    private static function removeLastPath($path, $n = 1)
    {
        $t = explode('.', $path);
        $result = '';

        for ($i = 0; $i < count($t) - $n; $i++) {
            $result .= strlen($result) > 0 ? ".$t[$i]" : $t[$i];
        }

        return $result;
    }

    /**
     * @param string $line
     * @return bool
     */
    private static function containValue($line)
    {
        if (self::isValue($line)) {
            return true;
        } else {
            $l = trim($line);
            $t = explode(':', $l);
            return count($t) == 2 ? $t[1] != '' : false;
        }
    }

    /**
     * @param string $line
     * @return int
     */
    private static function countTabulations($line)
    {
        $i = 0;
        $c = strlen($line) > 0 ? $line[$i] : '';
        while ($c == ' ' && $i < strlen($line)) {
            $i++;
            $c = $line[$i];
        }

        return $i / 2;
    }

    /**
     * @param array $array
     * @param int $nbTab
     * @return string
     */
    private static function arrayToYaml(array $array, $nbTab)
    {
        $result = '';

        foreach ($array as $name => $value) {
            $result .= self::getTabs($nbTab);

            if (is_array($value)) {
                $result .= "$name:\n" . self::arrayToYaml($value, $nbTab + 1);
            } else {
                if (is_numeric($name)) {
                    $result .= '- ';
                } else {
                    $result .= "$name: ";
                }

                if (is_numeric($value)) {
                    $result .= $value;
                } else {
                    $result .= "\"$value\"";
                }
                $result .= "\n";
            }
        }

        return $result;
    }

    private static function getTabs($nbTab)
    {
        $result = '';

        while ($nbTab > 0) {
            $result .= self::TAB;
            $nbTab--;
        }

        return $result;
    }
}