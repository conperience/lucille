<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Response;

/**
 * Class LucilleErrorResponse
 *
 * @package Lucille\Response
 */
class LucilleErrorResponse implements Response {
    
    /**
     * @var \Throwable
     */
    private $exception;
    
    /**
     * @var bool
     */
    private $verboseError;
    
    /**
     * @param \Throwable $exception    Exception object
     * @param bool       $verboseError enable debug output (display exception message and trace)
     */
    public function __construct(\Throwable $exception, bool $verboseError = false) {
        $this->exception = $exception;
        $this->verboseError = $verboseError;
    }
    
    /**
     * @return void
     * @codeCoverageIgnore
     */
    public function send(): void {
        // set HTTP status code
        http_response_code(500);
        
        // set mimetype
        header('Content-type: text/html');
        
        $message = 'Internal Server Error';
        $trace   = '';
        if ($this->verboseError) {
            $message = $this->exception->getFullMessage();
            $trace   = nl2br($this->exception->getTraceAsString());
        }
        
        echo <<< EOF
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Lucille Error</title>
    <style>
        #error {
         position:relative;
         margin:10px auto;
             color:#ff0000;
             background-color:#ffffff;
             font-size:13px;
             text-decoration:none;
             font-weight:normal;
             font-family:Arial, Verdana, Helvetica, Helv, sans-serif;			 
             text-align:left;				 
             border:1px solid #ff0000;
             padding: 20px;
             width:900px;
       }
    </style>
</head>
<body>
    <div id="error">
        <span style="font-size:15px; font-weight:bold;">Lucille Error</span><br/>
        <p>{$message}</p>
        {$trace}
    </div>
</body>
</html>
EOF;
    }
    
}
