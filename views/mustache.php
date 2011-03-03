<?php
App::import('Mustache', 'Mustache.Mustache', array(
    'file' => 'mustache' . DS . 'Mustache.php'));

class MustacheView extends View {
    public $ext = ".mustache";
    public $M = null;
    public $templatePaths = array();

    /**
     * __construct 
     * 
     * @param mixed $controller Controller instance
     * @param mixed $register 
     * @param mixed $mustache Mustache instance
     * @return void
     */
    public function __construct(&$controller, $mustache) {
		$this->templatePaths = array(
			APP.'views',
			ROOT.DS.'cake'.DS.'libs'.DS.'view'
		);

        $this->M = $mustache;
		parent::__construct($controller);

        // reset ext
        $this->ext = ".mustache";
    }

    /**
	 * Overwrite the default _render()
     *
     * There are three ways to render a mustache template
     *
     * First way:
     *      <?php
     *      echo $m->render('Hello {{planet}}', array('planet' => 'World!'));
     *      ?>
     * In this case, $___dataForView accepts a normal key-value array
     *
     * Second way:
     *      <?php
     *      class Chris {
     *          public $name = "Chris";
     *      }
     *      $chris = new Chris;
     *      echo $m->render($template, $chris);
     * In this case, it accepts an standard object
     *
     * Third way:
     *      <?php
     *      class Chris extends Mustache {
     *          public $name = "Chris";
     *      }
     *      $chris = new Chris;
     *      echo $chris->render($template);
     * 
     * To generalize, we will change how View::render works. Notice that this 
     * will break how Cake render its view if we use normally.
     * + We dont support layout here ( yet ), each template has to be one complete 
     * template
     *
     * Therefore, use this with care. KISS
     *
     * @param string $template relative path of the template, we will use 
     * $templatePath to scan your correct template
     * 
     * @param mixed $view View context of the template, either one of the 3 options 
     * above
     * $param mixed $partials Partials view of the template;
	 */
	public function render($template = null, $view = null, $partials = null) {
        $viewFileName = $this->_getViewFileName($template);
        ob_start();
        include ($viewFileName);
        $template = ob_get_clean();
        return $this->M->render($template, $view, $partials);
	}
}
