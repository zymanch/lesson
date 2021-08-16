<?php

namespace helper\traits;

trait ErrorsAsString
{
    public function getErrorsAsString($prefix = "")
    {
        $errors = $this->getErrors();
        $string = "";
        if (empty($errors)) {
            return $string;
        }
        $string .= $prefix;
        foreach ($errors as $attribute => $attributeErrors) {
            foreach ($attributeErrors as $error) {
                $string .= ($prefix ? "&nbsp;" : "") . $error . "\n";
            }
        }
        return $string;
    }
}