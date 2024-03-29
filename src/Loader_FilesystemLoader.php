<?php declare(strict_types=1);

namespace VitesseCms\Mustache;

/*
 * This file is part of Mustache.php.
 *
 * (c) 2010-2016 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Mustache_Exception_RuntimeException;
use Mustache_Exception_UnknownTemplateException;
use Mustache_Loader;
use Phalcon\Di\Di;

/**
 * Mustache Template filesystem Loader implementation.
 *
 * A FilesystemLoader instance loads Mustache Template source from the filesystem by name:
 *
 *     $loader = new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views');
 *     $tpl = $loader->load('foo'); // equivalent to `file_get_contents(dirname(__FILE__).'/Views/foo.mustache');
 *
 * This is probably the most useful Mustache Loader implementation. It can be used for partials and normal Templates:
 *
 *     $m = new Mustache(array(
 *          'loader'          => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views'),
 *          'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/Views/partials'),
 *     ));
 */
class Loader_FilesystemLoader implements Mustache_Loader
{
    /**
     * @var string
     */
    protected $baseDir;

    /**
     * @var string
     */
    protected $baseDirOrg;

    /**
     * @var string
     */
    protected $extension = '.mustache';

    /**
     * @var array
     */
    protected $templates = [];

    /**
     * Mustache filesystem Loader constructor.
     *
     * Passing an $options array allows overriding certain Loader options during instantiation:
     *
     *     $options = array(
     *         // The filename extension used for Mustache template. Defaults to '.mustache'
     *         'extension' => '.ms',
     *     );
     *
     * @param string $baseDir Base directory containing Mustache template files
     * @param array $options Array of Loader options (core: array())
     * @throws Mustache_Exception_RuntimeException if $baseDir does not exist
     *
     */
    public function __construct(string $baseDir, array $options = [])
    {
        $this->baseDir = $baseDir;
        $this->baseDirOrg = $baseDir;

        if (strpos($this->baseDir, '://') === false) {
            $this->baseDir = realpath($this->baseDir);
        }

        if ($this->shouldCheckPath() && !is_dir($this->baseDir)) {
            throw new Mustache_Exception_RuntimeException(sprintf('FilesystemLoader baseDir must be a directory: %s', $baseDir));
        }

        if (array_key_exists('extension', $options)) {
            if (empty($options['extension'])) {
                $this->extension = '';
            } else {
                $this->extension = '.' . ltrim($options['extension'], '.');
            }
        }
    }

    /**
     * Only check if baseDir is a directory and requested template are files if
     * baseDir is using the filesystem stream wrapper.
     *
     * @return bool Whether to check `is_dir` and `file_exists`
     */
    protected function shouldCheckPath(): bool
    {
        return strpos($this->baseDir, '://') === false || strpos($this->baseDir, 'file://') === 0;
    }

    /**
     * Load a Template by name.
     *
     *     $loader = new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views');
     *     $loader->load('admin/dashboard'); // loads "./Views/Admin/dashboard.mustache";
     *
     * @param string $name
     *
     * @return string Mustache Template source
     */
    public function load($name): string
    {
        $this->setBaseDir($this->baseDirOrg);
        if (!is_file($this->baseDir . '/' . $name . $this->extension)) :
            $this->setBaseDir(Di::getDefault()->get('config')->get('defaultTemplateDir') . 'views/partials');
        endif;

        if (!isset($this->templates[$name])) {
            $this->templates[$name] = $this->loadFile($name);
        }

        return $this->templates[$name];
    }

    /**
     * @param string $dir
     */
    protected function setBaseDir(string $dir): void
    {
        $this->baseDir = $dir;
    }

    /**
     * Helper function for loading a Mustache file by name.
     *
     * @param string $name
     *
     * @return string Mustache Template source
     * @throws Mustache_Exception_UnknownTemplateException If a template file is not found
     *
     */
    protected function loadFile(string $name): string
    {
        $fileName = $this->getFileName($name);

        if ($this->shouldCheckPath() && !file_exists($fileName)) {
            throw new Mustache_Exception_UnknownTemplateException($name);
        }

        return file_get_contents($fileName);
    }

    /**
     * Helper function for getting a Mustache template file name.
     *
     * @param string $name
     *
     * @return string Template file name
     */
    protected function getFileName(string $name): string
    {
        $fileName = $this->baseDir . '/' . $name;
        if (substr($fileName, 0 - strlen($this->extension)) !== $this->extension) {
            $fileName .= $this->extension;
        }

        return $fileName;
    }
}
