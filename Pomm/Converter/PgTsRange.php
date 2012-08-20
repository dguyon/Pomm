<?php

namespace Pomm\Converter;

use Pomm\Converter\ConverterInterface;
use Pomm\Type\TsRange;
use Pomm\Exception\Exception;

/**
 * Pomm\Converter\PgTsRange - Timestamp range converter
 * 
 * @package Pomm
 * @version $id$
 * @copyright 2012 Grégoire HUBERT 
 * @author Grégoire HUBERT <hubert.greg@gmail.com>
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 */
class PgTsRange implements ConverterInterface
{
    protected $class_name;

    /**
     * __construct()
     *
     * @param String            $class_name      Optional fully qualified TsRange type class name.
     **/
    public function __construct($class_name = 'Pomm\Type\TsRange')
    {
        $this->class_name = $class_name;
    }

    /**
     * @see Pomm\Converter\ConverterInterface
     **/
    public function fromPg($data, $type = null)
    {
        if (!preg_match('/([\[\(])"([0-9 :-]+)","([0-9 :-]+)"([\]\)])/', $data, $matchs))
        {
            throw new Exception(sprintf("Bad timestamp range representation '%s' (asked type '%s').", $data, $type));
        }

        return new TsRange(new \DateTime($matchs[2]), new \DateTime($matchs[3]), $matchs[1] === '[', $matchs[4] === ']');
    }

    /**
     * @see Pomm\Converter\ConverterInterface
     **/
    public function toPg($data, $type = null)
    {
        return sprintf("tsrange '%s'", (string) $data);
    }
}