<?php
namespace Tasyakur\Providers\ACF\Migrations;

use Tasyakur\Core\Contracts\HooksInterface;
use Tasyakur\Providers\ACF\Contracts\FieldInterface;

abstract class Group implements HooksInterface
{
    /**
     * @var array
     */
    protected $fields = [];

    /**
     * ACF Group constructor.
     * @param array ...$fieldClasses FieldInterface
     */
    public function __construct(...$fieldClasses)
    {
        if (!is_array($fieldClasses) && func_num_args() > 0)
            $fieldClasses = func_get_args();

        foreach ($fieldClasses as $fieldClass) {
            $field = app()->get($fieldClass);
            if ($field instanceof FieldInterface) {
                $this->fields = array_merge($this->fields, $field->getField());
            }
        }
    }
}