<?php

namespace spec\Neoxygen\NeoConnect\Connection;

use PhpSpec\ObjectBehavior;

class ConnectionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('default');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\Connection\Connection');
    }

    public function it_should_have_an_alias()
    {
        $this->getAlias()->shouldReturn('default');
    }

    public function its_scheme_should_be_defined_by_default()
    {
        $this->getScheme()->shouldReturn('http');
    }

    public function its_scheme_should_be_mutable()
    {
        $this->setScheme('https');
        $this->getScheme()->shouldReturn('https');
    }

    public function its_scheme_should_be_http_or_https()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('setScheme', array('rtp'));
    }

    public function its_host_should_be_defined_by_default()
    {
        $this->getHost()->shouldReturn('localhost');
    }

    public function its_host_should_be_mutable()
    {
        $this->setHost('10.2.2.2');
        $this->getHost()->shouldReturn('10.2.2.2');
    }

    public function its_port_should_be_defined_by_default()
    {
        $this->getPort()->shouldReturn(7474);
    }

    public function its_port_should_be_mutable()
    {
        $this->setPort(7575);
        $this->getPort()->shouldReturn(7575);
    }

    public function its_auth_mode_should_be_false_by_default()
    {
        $this->getAuthMode()->shouldReturn(false);
    }

    public function its_auth_mode_should_be_mutable()
    {
        $this->setAuthMode();
        $this->getAuthMode()->shouldReturn(true);
    }

    public function its_user_connection_setting_should_be_null_by_default()
    {
        $this->getUser()->shouldBeNull();
    }

    public function its_user_should_be_mutable()
    {
        $this->setUser('ikwattro');
        $this->getUser()->shouldReturn('ikwattro');
    }

    public function its_password_should_be_null_by_default()
    {
        $this->getPassword()->shouldBeNull();
    }

    public function its_password_should_be_mutable()
    {
        $this->setPassword('mySecret');
        $this->getPassword()->shouldReturn('mySecret');
    }

    public function it_should_not_have_a_commit_strategy_by_default()
    {
        $this->getCommitStrategy()->shouldReturn(null);
    }

    public function its_commit_strategy_should_be_mutable()
    {
        $this->setCommitStrategy('auto');
        $this->getCommitStrategy()->shouldReturn('auto');
    }
}
