<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Components\Stream;
    
use Lucille\Directory;
use Lucille\Components\Stream\Exceptions\CannotRegisterStreamException;
use Lucille\Components\Stream\Exceptions\CannotUnregisterStreamException;
use Lucille\Components\Stream\Exceptions\StreamAlreadyRegisteredException;
use Lucille\Components\Stream\Exceptions\StreamNotRegisteredException;

/**
 * Class Stream
 *
 * @package Lucille\Components\Stream
 */
class Stream {
    
    /**
     * Registered streams with their paths
     *
     * @var array
     */
    private static $registered = array();

    /**
     * File handle
     *
     * @var resource
     */
    private $fp;

    /**
     * Directory handle
     *
     * @var resource
     */
    private $dh;
    
    /**
     * @param StreamName $name scheme name
     * @param Directory  $path target path
     * @return void
     * @throws CannotRegisterStreamException
     * @throws StreamAlreadyRegisteredException
     */
    public static function registerStream(StreamName $name, Directory $path): void {
        if (self::isRegistered($name)) {
            throw new StreamAlreadyRegisteredException($name);
        }
        
        if (!stream_wrapper_register($name->asString(), '\\Lucille\\Components\\Stream\\Stream')) {
            throw new CannotRegisterStreamException($name);
        }
        
        self::$registered[$name->asString()] = $path->asString();
    }
    
    /**
     * @param StreamName $name scheme name
     * @return void
     * @throws CannotUnregisterStreamException
     */
    public static function unregisterStream(StreamName $name): void {
        if (self::isRegistered($name)) {
            if (!stream_wrapper_unregister($name->asString())) {
                throw new CannotUnregisterStreamException($name);
            }
            unset(self::$registered[$name->asString()]);
        }
    }
    
    /**
     * @param StreamName $name protocol name
     * @return bool
     */
    public static function isRegistered(StreamName $name): bool {
        return isset(self::$registered[$name->asString()]);
    }
    
    /**
     * @param StreamName $name protocol name
     * @return string
     * @throws StreamNotRegisteredException
     */
    public static function getRegisteredPath(StreamName $name): string {
        if (!self::isRegistered($name)) {
            throw new StreamNotRegisteredException($name);
        }
        return self::$registered[$name->asString()];
    }

    /**
     * @param string $uri URI
     * @return string
     * @throws StreamNotRegisteredException
     */
    public static function translate(string $uri): string {
        $tmp = array();
        preg_match("=^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?=", $uri, $tmp);
        
        $streamName = new StreamName($tmp[2]);
        if (!self::isRegistered($streamName)) {
            return $uri;
        }
        
        $path = '';
        
        // append fractions
        if ($tmp[4] != '') {
            $path .= '/'.$tmp[4].$tmp[5];
        } elseif ($tmp[5] != '/') {
            $path .= $tmp[5];
        }
        
        return self::getRegisteredPath($streamName).$path;
    }
    
    /**
     * @param string $path stream path
     * @param string $mode stream mode
     * @return bool
     * @throws StreamNotRegisteredException
     */
    public function stream_open(string $path, string $mode) {
        $fname = self::translate($path);
        if (!$fname) {
            return false;
        }
        
        $this->fp = fopen($fname, $mode);
        if (!$this->fp) {
            return false;
        }
        return true;
    }
    
    /**
     * @return void
     */
    public function stream_close(): void {
        fclose($this->fp);
        $this->fp = 0;
    }
    
    /**
     * @param int $count bytes count
     * @return string
     */
    public function stream_read(int $count) {
        return fread($this->fp, $count);
    }
    
    /**
     * @param string $data data payload
     * @return bool|int
     */
    public function stream_write($data) {
        return fwrite($this->fp, $data);
    }
    
    /**
     * @return bool
     */
    public function stream_eof() {
        return feof($this->fp);
    }
    
    /**
     * @return bool|int
     */
    public function stream_tell() {
        return ftell($this->fp);
    }
    
    /**
     * @param int $offset offset
     * @param int $whence whence
     * @return int
     */
    public function stream_seek($offset, $whence) {
        return fseek($this->fp, $offset, $whence);
    }
    
    /**
     * @return bool
     */
    public function stream_flush() {
        return fflush($this->fp);
    }
    
    /**
     * @return array
     */
    public function stream_stat() {
        return fstat($this->fp);
    }

    /**
     * @param string $path stream path
     * @return bool
     */
    public function unlink(string $path) {
        $fpath = self::translate($path);
        if (!$fpath) {
            return false;
        }
        return unlink($fpath);
    }
    
    /**
     * @param string $from from filename
     * @param string $to   to filename
     * @return bool
     */
    public function rename(string $from, string $to) {
        $fpath = self::translate($from);
        if (!$fpath) {
            return false;
        }
        
        $tpath = self::translate($to);
        if (!$tpath) {
            return false;
        }
        
        return rename($fpath, $tpath);
    }
    
    /**
     * @param string $path  path
     * @param int    $flags flags
     * @return array|bool
     */
    public function url_stat(string $path, $flags) {
        $fname = self::translate($path);
        if (!$fname || !file_exists($fname)) {
            return false;
        }
        return stat($fname);
    }
    
    /**
     * @param string $path    path
     * @param int    $mode    file/dir mode
     * @param int    $options options
     * @return bool
     */
    public function mkdir(string $path, int $mode, $options): bool {
        $fpath=self::translate($path);
        if (!$fpath) {
            return false;
        }
        return mkdir($fpath, $mode, $options);
    }
    
    /**
     * @param string $path    path
     * @param int    $options options
     * @return bool
     */
    public function rmdir(string $path, $options): bool {
        $fpath=self::translate($path);
        if (!$fpath) {
            return false;
        }
        return rmdir($fpath);
    }
    
    /**
     * @param string $path    path
     * @param int    $options options
     * @return bool
     */
    public function dir_opendir(string $path, $options): bool {
        $fpath=self::translate($path);
        if (!$fpath) {
            return false;
        }
        $this->dh = opendir($fpath);
        return ($this->dh>0) ? true : false;
    }

    /**
     * @return bool|string
     */
    public function dir_readdir() {
        return readdir($this->dh);
    }
    
    /**
     * @return bool
     */
    public function dir_rewinddir() {
        return rewinddir($this->dh);
    }
    
    /**
     * @return bool
     */
    public function dir_closedir() {
        closedir($this->dh);
        $this->dh = 0;
        return true;
    }
    
}
