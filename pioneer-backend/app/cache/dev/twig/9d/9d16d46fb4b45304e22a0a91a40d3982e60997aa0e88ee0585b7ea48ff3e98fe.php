<?php

/* FOSUserBundle:Group:list.html.twig */
class __TwigTemplate_59d89e04e4cca3b1c8ea502af10e26368080ff78116209345fd0e281294957f0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:Group:list.html.twig", 1);
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
        $__internal_7fb108c0d4303537c34c6d1aebf6a215ecd0ce8892e7b646d498d5c6ba214deb = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_7fb108c0d4303537c34c6d1aebf6a215ecd0ce8892e7b646d498d5c6ba214deb->enter($__internal_7fb108c0d4303537c34c6d1aebf6a215ecd0ce8892e7b646d498d5c6ba214deb_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Group:list.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_7fb108c0d4303537c34c6d1aebf6a215ecd0ce8892e7b646d498d5c6ba214deb->leave($__internal_7fb108c0d4303537c34c6d1aebf6a215ecd0ce8892e7b646d498d5c6ba214deb_prof);

    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_cbe6a5659e82cda14e2c4fa68e58e8326e5296b5c76b71e37af7b9786952ef43 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_cbe6a5659e82cda14e2c4fa68e58e8326e5296b5c76b71e37af7b9786952ef43->enter($__internal_cbe6a5659e82cda14e2c4fa68e58e8326e5296b5c76b71e37af7b9786952ef43_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 4
        $this->loadTemplate("FOSUserBundle:Group:list_content.html.twig", "FOSUserBundle:Group:list.html.twig", 4)->display($context);
        
        $__internal_cbe6a5659e82cda14e2c4fa68e58e8326e5296b5c76b71e37af7b9786952ef43->leave($__internal_cbe6a5659e82cda14e2c4fa68e58e8326e5296b5c76b71e37af7b9786952ef43_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Group:list.html.twig";
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
{% include \"FOSUserBundle:Group:list_content.html.twig\" %}
{% endblock fos_user_content %}
", "FOSUserBundle:Group:list.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/friendsofsymfony/user-bundle/Resources/views/Group/list.html.twig");
    }
}
