<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */
    
namespace Lucille;
    
use Lucille\Result\Result;

/**
 * Interface Command
 *
 * @package Lucille
 */
interface Command {
    
    /**
     * @return Result
     */
    public function execute(): Result;
    
}
