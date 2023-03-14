<?php

namespace App\Drivers;

use App\OrganizationalUnit;

class MermaidJs
{
    private OrganizationalUnit $root;

    public function __construct(OrganizationalUnit $root)
    {
        $this->root = $root;
    }

    public function translate()
    {
        function descendants (OrganizationalUnit $node) {
            return $node->children->reduce(function ($carry, $child) {
                if ($child->group) {
                    return $carry . 'rectangle ' . $child->name . '{' . descendants($child) . '}';
                }
                return $carry . 'person ' . $child->name . '{' . descendants($child) . '}';
            });
        }

        return descendants($this->root);
    }


}
