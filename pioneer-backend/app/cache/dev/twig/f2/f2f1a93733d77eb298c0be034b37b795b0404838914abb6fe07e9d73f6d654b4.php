<?php

/* FOSUserBundle:Security:login.html.twig */
class __TwigTemplate_6df3e02bd4faf80f83d0695b3069efb5728d3eba46d57b62b9f2bbc6a3897f16 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:Security:login.html.twig", 1);
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
        $__internal_3f9ae1c576f31c6348587f246947a1d98d05d3b255a0feb5f1e59bff7190a0db = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_3f9ae1c576f31c6348587f246947a1d98d05d3b255a0feb5f1e59bff7190a0db->enter($__internal_3f9ae1c576f31c6348587f246947a1d98d05d3b255a0feb5f1e59bff7190a0db_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Security:login.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_3f9ae1c576f31c6348587f246947a1d98d05d3b255a0feb5f1e59bff7190a0db->leave($__internal_3f9ae1c576f31c6348587f246947a1d98d05d3b255a0feb5f1e59bff7190a0db_prof);

    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_ea52fefd65ad35cc9d86c93c39a7920a1d22de4b10111d3902170ad67e673dc2 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ea52fefd65ad35cc9d86c93c39a7920a1d22de4b10111d3902170ad67e673dc2->enter($__internal_ea52fefd65ad35cc9d86c93c39a7920a1d22de4b10111d3902170ad67e673dc2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 4
        echo "    ";
        echo twig_include($this->env, $context, "FOSUserBundle:Security:login_content.html.twig");
        echo "
";
        
        $__internal_ea52fefd65ad35cc9d86c93c39a7920a1d22de4b10111d3902170ad67e673dc2->leave($__internal_ea52fefd65ad35cc9d86c93c39a7920a1d22de4b10111d3902170ad67e673dc2_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Security:login.html.twig";
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
    {{ include('FOSUserBundle:Security:login_content.html.twig') }}
{% endblock fos_user_content %}
", "FOSUserBundle:Security:login.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/friendsofsymfony/user-bundle/Resources/views/Security/login.html.twig");
    }
}
