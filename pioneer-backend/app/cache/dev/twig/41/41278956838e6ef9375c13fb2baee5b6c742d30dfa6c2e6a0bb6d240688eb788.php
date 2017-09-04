<?php

/* FOSUserBundle:Profile:edit.html.twig */
class __TwigTemplate_81ce2383a48e5045443678a273605b58f8dae2304cec1b83d46d6ca5dabd03b4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:Profile:edit.html.twig", 1);
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
        $__internal_8de356d334be2f1d460934aae385202f98c2708d5254fe55c8c4fa487b5b1731 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_8de356d334be2f1d460934aae385202f98c2708d5254fe55c8c4fa487b5b1731->enter($__internal_8de356d334be2f1d460934aae385202f98c2708d5254fe55c8c4fa487b5b1731_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Profile:edit.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_8de356d334be2f1d460934aae385202f98c2708d5254fe55c8c4fa487b5b1731->leave($__internal_8de356d334be2f1d460934aae385202f98c2708d5254fe55c8c4fa487b5b1731_prof);

    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_21ec1149244d634f88c16255b8e1c351ee8c2e72123492a515683ff0048be77d = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_21ec1149244d634f88c16255b8e1c351ee8c2e72123492a515683ff0048be77d->enter($__internal_21ec1149244d634f88c16255b8e1c351ee8c2e72123492a515683ff0048be77d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 4
        $this->loadTemplate("FOSUserBundle:Profile:edit_content.html.twig", "FOSUserBundle:Profile:edit.html.twig", 4)->display($context);
        
        $__internal_21ec1149244d634f88c16255b8e1c351ee8c2e72123492a515683ff0048be77d->leave($__internal_21ec1149244d634f88c16255b8e1c351ee8c2e72123492a515683ff0048be77d_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Profile:edit.html.twig";
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
{% include \"FOSUserBundle:Profile:edit_content.html.twig\" %}
{% endblock fos_user_content %}
", "FOSUserBundle:Profile:edit.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/friendsofsymfony/user-bundle/Resources/views/Profile/edit.html.twig");
    }
}
