<?php
namespace IgetMaster\MaterialAdmin\Filters;

use Exception;
use IgetMaster\MaterialAdmin\Interfaces\FilterInterface;

class StringFilter implements FilterInterface{
    protected $field;
    protected $condition;
    protected $value;

    function __construct($field, $condition, $value)
    {
        $this->field = $field;
        $this->condition = $condition;
        $this->value = $value;
    }

    static public function contains($field, $value) {
        return new static($field, 'contains', $value);
    }

    static public function starts($field, $value) {
        return new static($field, 'starts', $value);
    }

    static public function ends($field, $value) {
        return new static($field, 'ends', $value);
    }

    static public function exact($field, $value) {
        return new static($field, 'exact', $value);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter($query)
    {
        $value = $this->value;
        switch($this->condition) {
            case 'contains':
                $value = "%${value}%";
                break;
            case 'starts':
                $value .= "%";
                break;
            case 'ends':
                $value = "%" . $value;
            case 'exact':
                break;
            default:
                throw new Exception('Invalid filter condition "' . $this->condition . '".');
        }
        return $query->where($this->field, 'LIKE', $value);
    }
}