<?php

/* UserBundle:Default:index.html.twig */
class __TwigTemplate_d0459783ee001900e5394c1ea419c95037628c0a1834361194b0ec05ca990f1a extends Twig_Template
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
        $__internal_2180f6c0e26a04bbd073d58162ad2fb9658bc5d889802f8d4a56b0fd3abd19fc = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_2180f6c0e26a04bbd073d58162ad2fb9658bc5d889802f8d4a56b0fd3abd19fc->enter($__internal_2180f6c0e26a04bbd073d58162ad2fb9658bc5d889802f8d4a56b0fd3abd19fc_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "UserBundle:Default:index.html.twig"));

        // line 1
        echo "Hello World!
";
        
        $__internal_2180f6c0e26a04bbd073d58162ad2fb9658bc5d889802f8d4a56b0fd3abd19fc->leave($__internal_2180f6c0e26a04bbd073d58162ad2fb9658bc5d889802f8d4a56b0fd3abd19fc_prof);

    }

    public function getTemplateName()
    {
        return "UserBundle:Default:index.html.twig";
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
", "UserBundle:Default:index.html.twig", "/var/www/html/pioneer/pioneer-backend/src/UserBundle/Resources/views/Default/index.html.twig");
    }
}
