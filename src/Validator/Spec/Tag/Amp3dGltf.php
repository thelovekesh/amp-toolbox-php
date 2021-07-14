<?php

/**
 * DO NOT EDIT!
 * This file was automatically generated via bin/generate-validator-spec.php.
 */

namespace AmpProject\Validator\Spec\Tag;

use AmpProject\Html\Attribute;
use AmpProject\Extension;
use AmpProject\Format;
use AmpProject\Layout;
use AmpProject\Protocol;
use AmpProject\Validator\Spec\AttributeList;
use AmpProject\Validator\Spec\Identifiable;
use AmpProject\Validator\Spec\SpecRule;
use AmpProject\Validator\Spec\Tag;

/**
 * Tag class Amp3dGltf.
 *
 * @package ampproject/amp-toolbox.
 *
 * @property-read string $tagName
 * @property-read array $attrs
 * @property-read array<string> $attrLists
 * @property-read array<array<string>> $ampLayout
 * @property-read array<string> $htmlFormat
 * @property-read array<string> $requiresExtension
 */
final class Amp3dGltf extends Tag implements Identifiable
{
    /**
     * ID of the tag.
     *
     * @var string
     */
    const ID = 'AMP-3D-GLTF';

    /**
     * Array of spec rules.
     *
     * @var array
     */
    const SPEC = [
        SpecRule::TAG_NAME => Extension::_3D_GLTF,
        SpecRule::ATTRS => [
            Attribute::ALPHA => [
                SpecRule::VALUE => [
                    'false',
                    'true',
                ],
            ],
            Attribute::ANTIALIASING => [
                SpecRule::VALUE => [
                    'false',
                    'true',
                ],
            ],
            Attribute::AUTOROTATE => [
                SpecRule::VALUE => [
                    'false',
                    'true',
                ],
            ],
            Attribute::CLEARCOLOR => [],
            Attribute::ENABLEZOOM => [
                SpecRule::VALUE => [
                    'false',
                    'true',
                ],
            ],
            Attribute::MAXPIXELRATIO => [
                SpecRule::VALUE_REGEX => '[+-]?(\d*\.)?\d+',
            ],
            Attribute::SRC => [
                SpecRule::MANDATORY => true,
                SpecRule::VALUE_URL => [
                    SpecRule::PROTOCOL => [
                        Protocol::HTTPS,
                    ],
                ],
            ],
        ],
        SpecRule::ATTR_LISTS => [
            AttributeList\ExtendedAmpGlobal::ID,
        ],
        SpecRule::AMP_LAYOUT => [
            SpecRule::SUPPORTED_LAYOUTS => [
                Layout::FILL,
                Layout::FIXED,
                Layout::FIXED_HEIGHT,
                Layout::FLEX_ITEM,
                Layout::RESPONSIVE,
            ],
        ],
        SpecRule::HTML_FORMAT => [
            Format::AMP,
        ],
        SpecRule::REQUIRES_EXTENSION => [
            Extension::_3D_GLTF,
        ],
    ];
}
