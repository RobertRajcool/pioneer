<?php

/* FOSUserBundle:Registration:email.txt.twig */
class __TwigTemplate_63e739e57f97ed678cdea70444205a7a199cc518ddd2ba589333247b48087125 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'subject' => array($this, 'block_subject'),
            'body_text' => array($this, 'block_body_text'),
            'body_html' => array($this, 'block_body_html'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_887c51e9d9d114060b41be5bc8cf46b20503ea5e037ccbf345ca92ffcb4e2082 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_887c51e9d9d114060b41be5bc8cf46b20503ea5e037ccbf345ca92ffcb4e2082->enter($__internal_887c51e9d9d114060b41be5bc8cf46b20503ea5e037ccbf345ca92ffcb4e2082_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Registration:email.txt.twig"));

        // line 2
        $this->displayBlock('subject', $context, $blocks);
        // line 7
        echo "
";
        // line 8
        $this->displayBlock('body_text', $context, $blocks);
        // line 13
        $this->displayBlock('body_html', $context, $blocks);
        
        $__internal_887c51e9d9d114060b41be5bc8cf46b20503ea5e037ccbf345ca92ffcb4e2082->leave($__internal_887c51e9d9d114060b41be5bc8cf46b20503ea5e037ccbf345ca92ffcb4e2082_prof);

    }

    // line 2
    public function block_subject($context, array $blocks = array())
    {
        $__internal_8f2269954f98c9f95d75dcfcac278f52f91d1c6e25167c8c9b3208d2cb7b6156 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_8f2269954f98c9f95d75dcfcac278f52f91d1c6e25167c8c9b3208d2cb7b6156->enter($__internal_8f2269954f98c9f95d75dcfcac278f52f91d1c6e25167c8c9b3208d2cb7b6156_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "subject"));

        // line 4
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("registration.email.subject", array("%username%" => $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "username", array()), "%confirmationUrl%" => ($context["confirmationUrl"] ?? $this->getContext($context, "confirmationUrl"))), "FOSUserBundle");
        
        $__internal_8f2269954f98c9f95d75dcfcac278f52f91d1c6e25167c8c9b3208d2cb7b6156->leave($__internal_8f2269954f98c9f95d75dcfcac278f52f91d1c6e25167c8c9b3208d2cb7b6156_prof);

    }

    // line 8
    public function block_body_text($context, array $blocks = array())
    {
        $__internal_ad8a2b6c5dac28d63ca95bf3d772842eb8bc2c60047f9473d636141c772bd670 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ad8a2b6c5dac28d63ca95bf3d772842eb8bc2c60047f9473d636141c772bd670->enter($__internal_ad8a2b6c5dac28d63ca95bf3d772842eb8bc2c60047f9473d636141c772bd670_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body_text"));

        // line 10
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("registration.email.message", array("%username%" => $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "username", array()), "%confirmationUrl%" => ($context["confirmationUrl"] ?? $this->getContext($context, "confirmationUrl"))), "FOSUserBundle");
        echo "
";
        
        $__internal_ad8a2b6c5dac28d63ca95bf3d772842eb8bc2c60047f9473d636141c772bd670->leave($__internal_ad8a2b6c5dac28d63ca95bf3d772842eb8bc2c60047f9473d636141c772bd670_prof);

    }

    // line 13
    public function block_body_html($context, array $blocks = array())
    {
        $__internal_9e06c67798204cc53c5b8fd5e51721a8b01c4282bb3fa3fd19930fd6f221aea4 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_9e06c67798204cc53c5b8fd5e51721a8b01c4282bb3fa3fd19930fd6f221aea4->enter($__internal_9e06c67798204cc53c5b8fd5e51721a8b01c4282bb3fa3fd19930fd6f221aea4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body_html"));

        
        $__internal_9e06c67798204cc53c5b8fd5e51721a8b01c4282bb3fa3fd19930fd6f221aea4->leave($__internal_9e06c67798204cc53c5b8fd5e51721a8b01c4282bb3fa3fd19930fd6f221aea4_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Registration:email.txt.twig";
    }

    public function getDebugInfo()
    {
        return array (  67 => 13,  58 => 10,  52 => 8,  45 => 4,  39 => 2,  32 => 13,  30 => 8,  27 => 7,  25 => 2,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% trans_default_domain 'FOSUserBundle' %}
{% block subject %}
{%- autoescape false -%}
{{ 'registration.email.subject'|trans({'%username%': user.username, '%confirmationUrl%': confirmationUrl}) }}
{%- endautoescape -%}
{% endblock %}

{% block body_text %}
{% autoescape false %}
{{ 'registration.email.message'|trans({'%username%': user.username, '%confirmationUrl%': confirmationUrl}) }}
{% endautoescape %}
{% endblock %}
{% block body_html %}{% endblock %}
", "FOSUserBundle:Registration:email.txt.twig", "/var/www/html/pioneer/pioneer-backend/vendor/friendsofsymfony/user-bundle/Resources/views/Registration/email.txt.twig");
    }
}
