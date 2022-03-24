<?php

namespace App\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Comma-separated attributes
     *
     */
    protected $commaSeparated = [];

    /**
     * Get a plain attribute (not a relationship).
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttributeValue($key)
    {
        $value = parent::getAttributeValue($key);

        if (in_array($key, $this->commaSeparated)) {
            return $this->getCommaSeparated($value);
        }

        return $value;
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->commaSeparated)) {
            return $this->setCommaSeparated($key, $value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Convert the model's attributes to an array.
     *
     * @return array
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($this->commaSeparated as $key) {
            if (!array_key_exists($key, $attributes)) {
                continue;
            }
            $attributes[$key] = $this->getCommaSeparated($attributes[$key]);
        }

        return $attributes;
    }

    /**
     * Get comma-separated attribute
     */
    private function getCommaSeparated($value)
    {
        if (is_array($value)) {
            return $value;
        } else {
            if (empty($value)) {
                return [];
            } else {
                $values = explode(',', $value);
                // intval не нужно применять, если хранятся строки (test1,test2,test3)
                if (is_numeric($values[0])) {
                    $values = array_map('intval', $values);
                }
                return $values;
            }
        }
    }

    /**
     * Set comma-separated attribute
     */
    private function setCommaSeparated($key, $value)
    {
        if (is_array($value)) {
            $this->attributes[$key] = implode(',', $value);
        } else {
            $this->attributes[$key] = $value;
        }
        return $this;
    }

    /**
     * Get a clean attribute, avoiding accessors/getters
     *
     */
    public function getClean($key)
    {
        return $this->getAttributes()[$key];
    }
}
