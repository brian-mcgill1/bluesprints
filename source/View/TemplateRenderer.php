<?php
namespace VerteXVaaR\BlueSprints\View;

use VerteXVaaR\BlueSprints\Http\Response;
use VerteXVaaR\BlueSprints\Utility\Files;

/**
 * Class TemplateRenderer
 *
 * @package VerteXVaaR\BlueSprints\View
 */
class TemplateRenderer
{

    /**
     * @var array
     */
    protected $variables = [];

    /**
     * @var TemplateHelper
     */
    protected $templateHelper = null;

    /**
     * @var Response
     */
    protected $response = null;

    /**
     * @param Response $response
     * @return TemplateRenderer
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
        $this->templateHelper = new TemplateHelper();
    }

    /**
     * @param string $templateName
     * @return void
     */
    public function render($templateName = '')
    {
        $this->setVariable('templateHelper', $this->templateHelper);
        ob_start();
        Files::requireOnceFile('html/Template/' . $templateName . '.php', $this->variables);
        $body = ob_get_contents();
        $this->response->appendContent($this->templateHelper->renderLayoutContent($body));
        ob_end_clean();
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setVariable($key = '', $value = null)
    {
        $this->variables[$key] = $value;
    }
}
