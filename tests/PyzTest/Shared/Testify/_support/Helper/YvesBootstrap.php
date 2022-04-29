<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Shared\Testify\Helper;

use Codeception\Exception\ModuleConfigException;
use Codeception\Lib\Framework;
use Pyz\Yves\ShopApplication\YvesBootstrap as PyzYvesBootstrap;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use SprykerTest\Shared\Testify\Helper\ConfigHelperTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelBrowser;

class YvesBootstrap extends Framework
{
    use ConfigHelperTrait;

    /**
     * @var \Pyz\Yves\ShopApplication\YvesBootstrap
     */
    private $yvesBootstrap;

    /**
     * @return void
     */
    public function _initialize()
    {
        $this->loadApplication();
    }

    /**
     * @param array $settings
     *
     * @return void
     */
    public function _beforeSuite($settings = [])
    {
        $this->disableWhoopsErrorHandler();
        $this->client = new HttpKernelBrowser($this->yvesBootstrap->boot());
    }

    /**
     * @throws \Codeception\Exception\ModuleConfigException
     *
     * @return void
     */
    protected function loadApplication()
    {
        $this->yvesBootstrap = new PyzYvesBootstrap();

        $requestFactory = function (array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null) {
            $request = new Request($query, $request, $attributes, $cookies, $files, $server, $content);
            $request->server->set('SERVER_NAME', 'localhost');

            return $request;
        };
        Request::setFactory($requestFactory);

        if (!isset($this->yvesBootstrap)) {
            throw new ModuleConfigException(self::class, 'Application instance was not received from bootstrap file');
        }
    }

    /**
     * @return void
     */
    protected function disableWhoopsErrorHandler(): void
    {
        $this->getConfigHelper()->setConfig(ErrorHandlerConstants::IS_PRETTY_ERROR_HANDLER_ENABLED, false);
    }
}
