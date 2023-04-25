<?php

namespace App\Drivers;

use App\OrganizationalUnit;
use SebastianBergmann\CodeCoverage\Report\PHP;

class PlantUml
{
    private OrganizationalUnit $root;

    public function __construct(OrganizationalUnit $root)
    {
        $this->root = $root->load('plantilla');
    }

    public function translate()
    {
        function descendants (OrganizationalUnit $node) {
            return $node->children->reduce(function ($carry, $child) {
                if ($child->group) {
                    return $carry .
                        'card "' . $child->group . '" as ' . preg_replace('/\W+/', '', $child->group) . '{' . PHP_EOL .
                            'label "<img:http://hris.app:8000/storage/project_files/profile.png{scale=0.06}>' . "\\n\\" . PHP_EOL .
                            ($child?->plantilla?->personalInformation?->fullName ?? 'VACANT') .'" as ' . preg_replace('/\W+/', '', $child->name) .  " << $child->name >>" . PHP_EOL .
                            descendants($child) . PHP_EOL.
                        '}' .
                        PHP_EOL;
                }
                return $carry .
                    'label "<img:http://hris.app:8000/storage/project_files/profile.png{scale=0.06}>' . "\\n\\" . PHP_EOL .
                    ($child?->plantilla?->personalInformation?->fullName ?? 'VACANT') .'" as ' . preg_replace('/\W+/', '', $child->name) . " << $child->name >>" .  PHP_EOL .
                    descendants($child) .
                    PHP_EOL;
            });
        }

        function links(OrganizationalUnit $root) {
            return $root->descendants->reduce(function ($carry, $child) use ($root) {
                if ($child->parent->is($root)) {
                    return $carry;
                }

                if ($child->group) {
                    return $carry . '"' . preg_replace('/\W+/', '', $child->parent->name) . '" --> "' . preg_replace('/\W+/', '', $child->group) . '" #line.bold' . PHP_EOL;
                }

                return $carry . '"' . preg_replace('/\W+/', '', $child->parent->name) . '" --> "' . preg_replace('/\W+/', '', $child->name) . '" #line.bold' . PHP_EOL;
            });
        }

        function encodep(string $puml): string
        {
            $compressed = gzdeflate($puml, 9);

            if (false === $compressed) {
                throw new \RuntimeException('Error while compressing PlantUml diagram.');
            }

            return encode64($compressed);
        }

        function encode64(string $compressed): string
        {
            $encoded = '';
            $length = mb_strlen($compressed, '8bit');
            for ($i = 0; $i < $length; $i += 3) {
                switch ($length) {
                    case $i + 1:
                        $encoded .= append3bytes(ord($compressed[$i]), 0, 0);
                        break;
                    case $i + 2:
                        $encoded .= append3bytes(ord($compressed[$i]), ord($compressed[$i + 1]), 0);
                        break;
                    default:
                        $encoded .= append3bytes(ord($compressed[$i]), ord($compressed[$i + 1]), ord($compressed[$i + 2]));
                        break;
                }
            }

            return $encoded;
        }

        function append3bytes(int $b1, int $b2, int $b3): string
        {
            $c1 = $b1 >> 2;
            $c2 = (($b1 & 0x3) << 4) | ($b2 >> 4);
            $c3 = (($b2 & 0xF) << 2) | ($b3 >> 6);
            $c4 = $b3 & 0x3F;
            $r = encode6bit($c1 & 0x3F);
            $r .= encode6bit($c2 & 0x3F);
            $r .= encode6bit($c3 & 0x3F);
            $r .= encode6bit($c4 & 0x3F);

            return $r;
        }

        function encode6bit(int $b): string
        {
            if ($b < 10) {
                return chr(48 + $b);
            }
            $b -= 10;
            if ($b < 26) {
                return chr(65 + $b);
            }
            $b -= 26;
            if ($b < 26) {
                return chr(97 + $b);
            }
            $b -= 26;
            if ($b === 0) {
                return '-';
            }
            if ($b === 1) {
                return '_';
            }

            return '?';
        }

        return encodep(
            '!theme toy' . PHP_EOL .
            'allowmixing' . PHP_EOL .
            'skinparam linetype polyline' . PHP_EOL .
            'skinparam defaultTextAlignment center' . PHP_EOL .
            'title ' . $this->root->name . PHP_EOL .
            "rectangle {" . PHP_EOL .
                (descendants($this->root) ?? '') . PHP_EOL .
            "}" . PHP_EOL .
            links($this->root)
        );
    }
}
