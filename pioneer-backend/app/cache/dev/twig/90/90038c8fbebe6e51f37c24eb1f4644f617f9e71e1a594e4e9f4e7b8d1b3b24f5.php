<?php

/* FOSUserBundle:Resetting:email.txt.twig */
class __TwigTemplate_66c4fdd9a65156a73774fd384560cc833e85ac9ee45c5376f0a0a8ebce0ccc83 extends Twig_Template
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
        $__internal_d0e9f94d2657c4d70341119b36745da7ff31ae4ff76b9ae4308abc2648c31c2d = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_d0e9f94d2657c4d70341119b36745da7ff31ae4ff76b9ae4308abc2648c31c2d->enter($__internal_d0e9f94d2657c4d70341119b36745da7ff31ae4ff76b9ae4308abc2648c31c2d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Resetting:email.txt.twig"));

        // line 2
        $this->displayBlock('subject', $context, $blocks);
        // line 7
        echo "
";
        // line 8
        $this->displayBlock('body_text', $context, $blocks);
        // line 13
        $this->displayBlock('body_html', $context, $blocks);
        
        $__internal_d0e9f94d2657c4d70341119b36745da7ff31ae4ff76b9ae4308abc2648c31c2d->leave($__internal_d0e9f94d2657c4d70341119b36745da7ff31ae4ff76b9ae4308abc2648c31c2d_prof);

    }

    // line 2
    public function block_subject($context, array $blocks = array())
    {
        $__internal_bf54fd3ffcd84dc8b1459a6629d7046298016f624140a4152ae30b3ed9da9a37 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_bf54fd3ffcd84dc8b1459a6629d7046298016f624140a4152ae30b3ed9da9a37->enter($__internal_bf54fd3ffcd84dc8b1459a6629d7046298016f624140a4152ae30b3ed9da9a37_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "subject"));

        // line 4
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("resetting.email.subject", array("%username%" => $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "username", array())), "FOSUserBundle");
        
        $__internal_bf54fd3ffcd84dc8b1459a6629d7046298016f624140a4152ae30b3ed9da9a37->leave($__internal_bf54fd3ffcd84dc8b1459a6629d7046298016f624140a4152ae30b3ed9da9a37_prof);

    }

    // line 8
    public function block_body_text($context, array $blocks = array())
    {
        $__internal_5a4f228cbb2fecd5fb32a9cba330327febf5fad80f86dadbee91b3234bd14d9b = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_5a4f228cbb2fecd5fb32a9cba330327febf5fad80f86dadbee91b3234bd14d9b->enter($__internal_5a4f228cbb2fecd5fb32a9cba330327febf5fad80f86dadbee91b3234bd14d9b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body_text"));

        // line 10
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("resetting.email.message", array("%username%" => $this->getAttribute(($context["user"] ?? $this->getContext($context, "user")), "username", array()), "%confirmationUrl%" => ($context["confirmationUrl"] ?? $this->getContext($context, "confirmationUrl"))), "FOSUserBundle");
        echo "
";
        
        $__internal_5a4f228cbb2fecd5fb32a9cba330327febf5fad80f86dadbee91b3234bd14d9b->leave($__internal_5a4f228cbb2fecd5fb32a9cba330327febf5fad80f86dadbee91b3234bd14d9b_prof);

    }

    // line 13
    public function block_body_html($context, array $blocks = array())
    {
        $__internal_634a214d76808062d6bd299dc79050055d4f63524bc3fcc2d605a6c224c05460 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_634a214d76808062d6bd299dc79050055d4f63524bc3fcc2d605a6c224c05460->enter($__internal_634a214d76808062d6bd299dc79050055d4f63524bc3fcc2d605a6c224c05460_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body_html"));

        
        $__internal_634a214d76808062d6bd299dc79050055d4f63524bc3fcc2d605a6c224c05460->leave($__internal_634a214d76808062d6bd299dc79050055d4f63524bc3fcc2d605a6c224c05460_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Resetting:email.txt.twig";
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
{{ 'resetting.email.subject'|trans({'%username%': user.username}) }}
{%- endautoescape -%}
{% endblock %}

{% block body_text %}
{% autoescape false %}
{{ 'resetting.email.message'|trans({'%username%': user.username, '%confirmationUrl%': confirmationUrl}) }}
{% endautoescape %}
{% endblock %}
{% block body_html %}{% endblock %}
", "FOSUserBundle:Resetting:email.txt.twig", "/var/www/html/pioneer/pioneer-backend/vendor/friendsofsymfony/user-bundle/Resources/views/Resetting/email.txt.twig");
    }
}
