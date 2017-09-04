<?php

/* FOSUserBundle:Resetting:reset.html.twig */
class __TwigTemplate_2ebb87c13f810ebc1a4dc612f6a602faa427b8435a015a75ad5a077f8b709489 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:Resetting:reset.html.twig", 1);
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
        $__internal_746200deff657d905dcc48dc9e94f05b0b2d2c870a3e9b43a73e0ce5f13418f2 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_746200deff657d905dcc48dc9e94f05b0b2d2c870a3e9b43a73e0ce5f13418f2->enter($__internal_746200deff657d905dcc48dc9e94f05b0b2d2c870a3e9b43a73e0ce5f13418f2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Resetting:reset.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_746200deff657d905dcc48dc9e94f05b0b2d2c870a3e9b43a73e0ce5f13418f2->leave($__internal_746200deff657d905dcc48dc9e94f05b0b2d2c870a3e9b43a73e0ce5f13418f2_prof);

    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_cc392d1d187d97c28631ad1aebff6ff5db8b9e69b34565d2f40cbecd47ec6630 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_cc392d1d187d97c28631ad1aebff6ff5db8b9e69b34565d2f40cbecd47ec6630->enter($__internal_cc392d1d187d97c28631ad1aebff6ff5db8b9e69b34565d2f40cbecd47ec6630_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 4
        $this->loadTemplate("FOSUserBundle:Resetting:reset_content.html.twig", "FOSUserBundle:Resetting:reset.html.twig", 4)->display($context);
        
        $__internal_cc392d1d187d97c28631ad1aebff6ff5db8b9e69b34565d2f40cbecd47ec6630->leave($__internal_cc392d1d187d97c28631ad1aebff6ff5db8b9e69b34565d2f40cbecd47ec6630_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Resetting:reset.html.twig";
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
{% include \"FOSUserBundle:Resetting:reset_content.html.twig\" %}
{% endblock fos_user_content %}
", "FOSUserBundle:Resetting:reset.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/friendsofsymfony/user-bundle/Resources/views/Resetting/reset.html.twig");
    }
}
