<?php

/* FOSUserBundle:Profile:show.html.twig */
class __TwigTemplate_01aeec30a8e376fb242b714185edbbb4cf63f11ce7d4997c1f6a37df0542ba45 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:Profile:show.html.twig", 1);
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
        $__internal_7aa66f47a76660474c32dfba457056cdfc6e9bb717be037028d87525dde5701a = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_7aa66f47a76660474c32dfba457056cdfc6e9bb717be037028d87525dde5701a->enter($__internal_7aa66f47a76660474c32dfba457056cdfc6e9bb717be037028d87525dde5701a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Profile:show.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_7aa66f47a76660474c32dfba457056cdfc6e9bb717be037028d87525dde5701a->leave($__internal_7aa66f47a76660474c32dfba457056cdfc6e9bb717be037028d87525dde5701a_prof);

    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_3f16cf7e3d5f330ae70ed602b98addfd63981ea42f67e0f847096dd44e127759 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_3f16cf7e3d5f330ae70ed602b98addfd63981ea42f67e0f847096dd44e127759->enter($__internal_3f16cf7e3d5f330ae70ed602b98addfd63981ea42f67e0f847096dd44e127759_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 4
        $this->loadTemplate("FOSUserBundle:Profile:show_content.html.twig", "FOSUserBundle:Profile:show.html.twig", 4)->display($context);
        
        $__internal_3f16cf7e3d5f330ae70ed602b98addfd63981ea42f67e0f847096dd44e127759->leave($__internal_3f16cf7e3d5f330ae70ed602b98addfd63981ea42f67e0f847096dd44e127759_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Profile:show.html.twig";
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
{% include \"FOSUserBundle:Profile:show_content.html.twig\" %}
{% endblock fos_user_content %}
", "FOSUserBundle:Profile:show.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/friendsofsymfony/user-bundle/Resources/views/Profile/show.html.twig");
    }
}
