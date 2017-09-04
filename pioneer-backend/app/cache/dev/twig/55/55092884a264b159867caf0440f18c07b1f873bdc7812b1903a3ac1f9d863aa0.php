<?php

/* FOSUserBundle:Registration:check_email.html.twig */
class __TwigTemplate_5672e65233d0c17464fba922ec2aa97dd28eaeb1b8e9416209e21536e27da1ae extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:Registration:check_email.html.twig", 1);
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
        $__internal_5ca4e7113a15b0ff0a35586e1b0d184d0db92a5cabfa4c4c613b5a7ae9108360 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_5ca4e7113a15b0ff0a35586e1b0d184d0db92a5cabfa4c4c613b5a7ae9108360->enter($__internal_5ca4e7113a15b0ff0a35586e1b0d184d0db92a5cabfa4c4c613b5a7ae9108360_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Registration:check_email.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_5ca4e7113a15b0ff0a35586e1b0d184d0db92a5cabfa4c4c613b5a7ae9108360->leave($__internal_5ca4e7113a15b0ff0a35586e1b0d184d0db92a5cabfa4c4c613b5a7ae9108360_prof);

    }

    // line 5
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_c47d471ace65518f692c35d004afe962389b052f46b0dd4bc3751eb3e30f1519 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_c47d471ace65518f692c35d004afe962389b052f46b0dd4bc3751eb3e30f1519->enter($__internal_c47d471ace65518f692c35d004afe962389b052f46b0dd4bc3751eb3e30f1519_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 6
        echo "    <p>";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("registration.check_email", array("%email%" => $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "email", array())), "FOSUserBundle"), "html", null, true);
        echo "</p>
";
        
        $__internal_c47d471ace65518f692c35d004afe962389b052f46b0dd4bc3751eb3e30f1519->leave($__internal_c47d471ace65518f692c35d004afe962389b052f46b0dd4bc3751eb3e30f1519_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Registration:check_email.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 6,  34 => 5,  11 => 1,);
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

{% trans_default_domain 'FOSUserBundle' %}

{% block fos_user_content %}
    <p>{{ 'registration.check_email'|trans({'%email%': user.email}) }}</p>
{% endblock fos_user_content %}
", "FOSUserBundle:Registration:check_email.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/friendsofsymfony/user-bundle/Resources/views/Registration/check_email.html.twig");
    }
}
