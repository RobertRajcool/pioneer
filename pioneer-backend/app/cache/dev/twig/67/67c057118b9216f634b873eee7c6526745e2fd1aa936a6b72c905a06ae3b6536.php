<?php

/* FOSUserBundle:Group:edit.html.twig */
class __TwigTemplate_078a8f2d7860cde4c07f900c38453d0a9a2f62d26035260f3fe131693342fa4b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:Group:edit.html.twig", 1);
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
        $__internal_3c92e379d2b0ee15f16b6a3239e81fa6dfd6d05e9b79f460967643e820a756b5 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_3c92e379d2b0ee15f16b6a3239e81fa6dfd6d05e9b79f460967643e820a756b5->enter($__internal_3c92e379d2b0ee15f16b6a3239e81fa6dfd6d05e9b79f460967643e820a756b5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Group:edit.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_3c92e379d2b0ee15f16b6a3239e81fa6dfd6d05e9b79f460967643e820a756b5->leave($__internal_3c92e379d2b0ee15f16b6a3239e81fa6dfd6d05e9b79f460967643e820a756b5_prof);

    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_2f7d1dbb00a73300c9848262f4c1fe707d1cbba53edab8e2a2827831732bb52c = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_2f7d1dbb00a73300c9848262f4c1fe707d1cbba53edab8e2a2827831732bb52c->enter($__internal_2f7d1dbb00a73300c9848262f4c1fe707d1cbba53edab8e2a2827831732bb52c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 4
        $this->loadTemplate("FOSUserBundle:Group:edit_content.html.twig", "FOSUserBundle:Group:edit.html.twig", 4)->display($context);
        
        $__internal_2f7d1dbb00a73300c9848262f4c1fe707d1cbba53edab8e2a2827831732bb52c->leave($__internal_2f7d1dbb00a73300c9848262f4c1fe707d1cbba53edab8e2a2827831732bb52c_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Group:edit.html.twig";
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
{% include \"FOSUserBundle:Group:edit_content.html.twig\" %}
{% endblock fos_user_content %}
", "FOSUserBundle:Group:edit.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/friendsofsymfony/user-bundle/Resources/views/Group/edit.html.twig");
    }
}
