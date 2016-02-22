<?php

/* _jsCssIncludes.twig */
class __TwigTemplate_7231bfe91b8bcd048dc834a87f181a42303d410d426b81906b4972defe9a0297 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        echo "    ";
        echo call_user_func_array($this->env->getFunction('includeAssets')->getCallable(), array(array("type" => "css")));
        echo "
    ";
        // line 3
        echo call_user_func_array($this->env->getFunction('includeAssets')->getCallable(), array(array("type" => "js")));
        echo "
";
    }

    public function getTemplateName()
    {
        return "_jsCssIncludes.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 3,  19 => 2,);
    }
}
