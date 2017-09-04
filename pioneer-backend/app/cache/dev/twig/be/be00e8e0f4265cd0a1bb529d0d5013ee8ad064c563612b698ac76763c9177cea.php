<?php

/* FOSUserBundle:Resetting:request.html.twig */
class __TwigTemplate_e01325bd97de850b36ba263c88051f785e8e09ce0d1adc68daf2b6d854ccbae1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:Resetting:request.html.twig", 1);
        $this->blocks = array(
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "FOSUserBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_af8d5d1290618009abb79e5c1dc99e711873ff45c340b9627d7d7b040f6b76f5 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_af8d5d1290618009abb79e5c1dc99e711873ff45c340b9627d7d7b040f6b76f5->enter($__internal_af8d5d1290618009abb79e5c1dc99e711873ff45c340b9627d7d7b040f6b76f5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Resetting:request.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_af8d5d1290618009abb79e5c1dc99e711873ff45c340b9627d7d7b040f6b76f5->leave($__internal_af8d5d1290618009abb79e5c1dc99e711873ff45c340b9627d7d7b040f6b76f5_prof);

    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_6570957705ec08a584e79d20ab65610dd7fec300bc1cff6211d3aed2a4881a5a = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_6570957705ec08a584e79d20ab65610dd7fec300bc1cff6211d3aed2a4881a5a->enter($__internal_6570957705ec08a584e79d20ab65610dd7fec300bc1cff6211d3aed2a4881a5a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 4
        $this->loadTemplate("FOSUserBundle:Resetting:request_content.html.twig", "FOSUserBundle:Resetting:request.html.twig", 4)->display($context);
        
        $__internal_6570957705ec08a584e79d20ab65610dd7fec300bc1cff6211d3aed2a4881a5a->leave($__internal_6570957705ec08a584e79d20ab65610dd7fec300bc1cff6211d3aed2a4881a5a_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Resetting:request.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 4,  34 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"FOSUserBundle::layout.html.twig\" %}

{% block fos_user_content %}
{% include \"FOSUserBundle:Resetting:request_content.html.twig\" %}
{% endblock fos_user_content %}
", "FOSUserBundle:Resetting:request.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/friendsofsymfony/user-bundle/Resources/views/Resetting/request.html.twig");
    }
}
