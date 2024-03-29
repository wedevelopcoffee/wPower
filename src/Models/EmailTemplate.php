<?php

namespace WeDevelopCoffee\wPower\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use WHMCS\Mail\Template;

/**
 * Class EmailTemplate
 */
class EmailTemplate extends Template
{
    /**
     * Filter on $type.
     *
     * @return object $this
     */
    public function filterOnType($type)
    {
        return self::where('type', $type);
    }

    /**
     * Create a template if it does not exist yet.
     */
    public function createIfDoesNotExist($type, $name, $subject, $message)
    {
        try {
            $template = $this->where('type', $type)
                ->where('name', $name)
                ->firstOrFail();

            return;

        } catch (ModelNotFoundException $e) {
            $this->type = $type;
            $this->name = $name;
            $this->subject = $subject;
            $this->message = $message;
            $this->save();
        }
    }
}
