<?php

/* @CoreHome/_warningInvalidHost.twig */
class __TwigTemplate_c40d95185ab830fdf60855844d9a061b8da31c3ab908bce09627bab37cfab35f extends Twig_Template
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
        if (((array_key_exists("isValidHost", $context) && array_key_exists("invalidHostMessage", $context)) && ((isset($context["isValidHost"]) ? $context["isValidHost"] : $this->getContext($context, "isValidHost")) == false))) {
            // line 3
            echo "    ";
            ob_start();
            // line 4
            echo "        <a class=\"btn btn-link\" style=\"float:right;\" href=\"http://piwik.org/faq/troubleshooting/#faq_171\" rel=\"noreferrer\" target=\"_blank\">
            <span class=\"icon-help\"></span>
            ";
            // line 6
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Help")), "html", null, true);
            echo "
        </a>
        <strong>";
            // line 8
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Warning")), "html", null, true);
            echo ":&nbsp;</strong>";
            echo (isset($context["invalidHostMessage"]) ? $context["invalidHostMessage"] : $this->getContext($context, "invalidHostMessage"));
            echo "

        <br>
        <br>

        ";
            // line 13
            echo (isset($context["invalidHostMessageHowToFix"]) ? $context["invalidHostMessageHowToFix"] : $this->getContext($context, "invalidHostMessageHowToFix"));
            echo "
    ";
            $context["invalidHostText"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            // line 15
            echo "
    <div style=\"clear:both;width:800px;\">
        ";
            // line 17
            echo call_user_func_array($this->env->getFilter('notification')->getCallable(), array((isset($context["invalidHostText"]) ? $context["invalidHostText"] : $this->getContext($context, "invalidHostText")), array("noclear" => true, "raw" => true, "context" => "warning")));
            echo "
    </div>

";
        }
        // line 21
        echo "
";
    }

    public function getTemplateName()
    {
        return "@CoreHome/_warningInvalidHost.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 21,  52 => 17,  48 => 15,  43 => 13,  33 => 8,  28 => 6,  24 => 4,  21 => 3,  19 => 2,);
    }
}
