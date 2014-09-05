<?php

namespace spec\Neoxygen\NeoConnect\Util;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IOSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\Util\IO');
    }

    function it_should_check_if_a_directory_exist()
    {
        $this->checkIfDirectoryExist(__DIR__)->shouldReturn(true);
    }

    function it_should_check_if_a_directory_is_writable()
    {
        $this->isWritable(__DIR__)->shouldReturn(true);
    }

    function it_should_create_a_directory()
    {
        $this->createDirectory($this->getTempDirName())->shouldReturn(true);
    }

    function it_should_delete_a_directory()
    {
        $dir = $this->getTempDirName();
        $this->createDirectory($dir)->shouldReturn(true);
        $this->removeDirectory($dir)->shouldReturn(true);
    }

    function it_should_create_a_file()
    {
        $f = $this->getTempFilePath();
        $this->touch($f)->shouldReturn(true);
    }

    function it_should_delete_a_file()
    {
        $f = $this->getTempFilePath();
        $this->touch($f);
        $this->removeFile($f)->shouldReturn(true);
    }

    function it_should_creates_file_with_content()
    {
        $f = $this->getTempFilePath();
        $this->dump($f, 'hello')->shouldBeInteger();
    }

    function it_should_assert_if_a_file_contains_content()
    {
        $f = $this->getTempFilePath();
        $this->dump($f, 'hello you');
        $this->fileHasContent($f, 'hello you')->shouldReturn(true);

        $f2 = $this->getTempFilePath();
        $this->dump($f2, 'hello');
        $this->fileHasContent($f2, 'hello me')->shouldReturn(false);
    }

    function it_should_check_if_a_file_exist()
    {
        $f = $this->getTempFilePath();
        $this->touch($f);
        $this->fileExist($f)->shouldReturn(true);
    }

    private function getTempDirName()
    {
        $cwd = getcwd();
        $dir = $cwd.'/spec/tmp/'.md5(microtime());

        return $dir;
    }

    private function getTempFilePath()
    {
        $dir = $this->getTempDirName();
        $path = $dir.'/'.md5(uniqid()).'.tmp';

        return $path;
    }
}
