<?php

/* DashboardBundle:Default:index.html.twig */
class __TwigTemplate_2f31177a5a204d5947e6c44a5c252805027074ad6f1cbd917329bb96eb2af353 extends Twig_Template
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
        $__internal_bcdff55040cbd874a82e519cb5e6b0aa2cdfd117d60ca5f79bc47d9a1df5c2ad = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_bcdff55040cbd874a82e519cb5e6b0aa2cdfd117d60ca5f79bc47d9a1df5c2ad->enter($__internal_bcdff55040cbd874a82e519cb5e6b0aa2cdfd117d60ca5f79bc47d9a1df5c2ad_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "DashboardBundle:Default:index.html.twig"));

        // line 1
        echo "Hello World!
";
        
        $__internal_bcdff55040cbd874a82e519cb5e6b0aa2cdfd117d60ca5f79bc47d9a1df5c2ad->leave($__internal_bcdff55040cbd874a82e519cb5e6b0aa2cdfd117d60ca5f79bc47d9a1df5c2ad_prof);

    }

    public function getTemplateName()
    {
        return "DashboardBundle:Default:index.html.twig";
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
        return new Twig_Source("Hello World!
", "DashboardBundle:Default:index.html.twig", "/var/www/html/pioneer/pioneer-backend/src/DashboardBundle/Resources/views/Default/index.html.twig");
    }
}
