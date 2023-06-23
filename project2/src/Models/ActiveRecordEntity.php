<?php

namespace Models;

use Services\Db;

abstract class ActiveRecordEntity
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    public function __set($name, $value)
    {
        $camelCaseName = $this->underScoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function underScoreToCamelCase(string $str)
    {
        return lcfirst(str_replace('_', '', ucwords($str, '_')));
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/([A-Z])/', '_$1', $source));
    }

    private function mapPropertiesToDbFormat(): array
    {

        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();
        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyToDbFormat = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyToDbFormat] = $this->$propertyName;
        }
        return $mappedProperties;
    }

    public function save()
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($mappedProperties['id'] !== null) {
            $this->update($mappedProperties);
        } else
            $this->insert($mappedProperties);
    }

    public function update(array $mappedProperties)
    {
        $db = Db::getInstance();
        $column2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index;
            $column2params[] = $column . '=' . $param;
            $params2values[$param] = $value;
            $index++;
        }
        $sql = 'UPDATE `' . static::getTableName() . '` SET ' . implode(',', $column2params) . ' WHERE id=' . $this->id;
        $db->query($sql, $params2values, static::class);
    }

    public function insert(array $mappedProperties)
    {
        $db = Db::getInstance();
        $filteredProperties = array_filter($mappedProperties);
        var_dump($filteredProperties);
        $columns = [];
        $column2params = [];
        $params2values = [];
        foreach ($filteredProperties as $column => $value) {
            $columns[] = '`' . $column . '`';
            $paramName = ':' . $column;
            $column2params[] = $paramName;
            $params2values[$paramName] = $value;
        }
        $sql1 = 'INSERT `' . static::getTableName() . '` (' . implode(',', $columns) . ') VALUES (' . implode(',', $column2params) . ')';
        var_dump($sql1);
        $db->query($sql1, $params2values, static::class);
    }

    public static function findAll(): ?array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`', [], static::class);
    }

    public static function getById(int $id): ?static
    {
        $db = Db::getInstance();
        $entities = $db->query('SELECT * FROM `' . static::getTableName() . '` WHERE `id`=:id', [':id' => $id], static::class);
        return $entities ? $entities[0] : null;
    }

    public function destroy()
    {
        $db = Db::getInstance();
        $sql = 'DELETE FROM `' . static::getTableName() . '` WHERE id=:id';
        $db->query($sql, [':id' => $this->id], static::class);
        $this->id = null;
    }

    abstract protected static function getTableName(): string;
}