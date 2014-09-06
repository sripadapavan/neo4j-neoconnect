<?php

namespace Neoxygen\NeoConnect\Util;

class IO
{

    public function checkIfDirectoryExist($directory)
    {
        return is_dir($directory);
    }

    public function isWritable($directory)
    {
        return is_writable($directory);
    }

    public function createDirectory($directory, $mode = 0777)
    {
        if (true === @mkdir($directory, $mode, true)) {
            chmod($directory, $mode);
            if (is_writable($directory)) {
                return true;
            }

            return false;

        }

        return false;
    }

    public function removeDirectory($directory)
    {
        return @rmdir($directory);
    }

    public function touch($filePath)
    {
        if (!is_dir(dirname($filePath))) {
            $this->createDirectory(dirname($filePath));

            if (false === @touch($filePath)) {
                throw new \RuntimeException(sprintf('Unable to create the file "%s" '));
            }
            chmod($filePath, 0777);

            return true;
        }

        return false;
    }

    public function removeFile($file)
    {
        if (false === @unlink($file)) {
            throw new \RuntimeException(sprintf('Unable to delete file "%s"', $file));
        }

        return true;
    }

    public function dump($file, $content)
    {
        if (!$this->touch($file)) {
            throw new \RuntimeException(sprintf('Unable to create file "%s"', $file));
        }
        if (!is_writable($file)) {
            throw new \RuntimeException(sprintf('The file "%s" is not writable', $file));
        }

        return file_put_contents($file, $content);
    }

    public function fileHasContent($file, $content)
    {
        $c = (string) $content;
        if (false === $fc = @file_get_contents($file)) {
            throw new \RuntimeException(sprintf('The file "%s" could not be find or opened', $file));
        }

        if (!1 == preg_match('^'.$content.'^', $fc)) {
            return false;
        }

        return true;
    }

    public function fileExist($filePath)
    {
        return file_exists($filePath);
    }
}
