<?php

/* TwigBundle:Exception:error.rdf.twig */
class __TwigTemplate_921f1e78e1b91b41f9eed469025f8f8479ba8b5e6380a705af0c016a3be6f089 extends Twig_Template
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
        $__internal_d8c029e05e0f3e114ca4bc77323bc294b6dfdb5310ad40fe6f1718e749a203a7 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_d8c029e05e0f3e114ca4bc77323bc294b6dfdb5310ad40fe6f1718e749a203a7->enter($__internal_d8c029e05e0f3e114ca4bc77323bc294b6dfdb5310ad40fe6f1718e749a203a7_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:error.rdf.twig"));

        // line 1
        $this->loadTemplate("@Twig/Exception/error.xml.twig", "TwigBundle:Exception:error.rdf.twig", 1)->display($context);
        
        $__internal_d8c029e05e0f3e114ca4bc77323bc294b6dfdb5310ad40fe6f1718e749a203a7->leave($__internal_d8c029e05e0f3e114ca4bc77323bc294b6dfdb5310ad40fe6f1718e749a203a7_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:error.rdf.twig";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% include '@Twig/Exception/error.xml.twig' %}
", "TwigBundle:Exception:error.rdf.twig", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/TwigBundle/Resources/views/Exception/error.rdf.twig");
    }
}
