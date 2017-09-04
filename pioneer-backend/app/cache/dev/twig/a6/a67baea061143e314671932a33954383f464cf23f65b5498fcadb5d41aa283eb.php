<?php

/* FOSUserBundle:Group:new.html.twig */
class __TwigTemplate_2472104e15f5c151a3a32c72f183b2d9e38e872918914c8ccf83afea99081f5d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:Group:new.html.twig", 1);
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
        $__internal_ba06d3baa593eb5d721825a80e08aa3e93c1aa4fff7d073467106eb0ce486116 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ba06d3baa593eb5d721825a80e08aa3e93c1aa4fff7d073467106eb0ce486116->enter($__internal_ba06d3baa593eb5d721825a80e08aa3e93c1aa4fff7d073467106eb0ce486116_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Group:new.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_ba06d3baa593eb5d721825a80e08aa3e93c1aa4fff7d073467106eb0ce486116->leave($__internal_ba06d3baa593eb5d721825a80e08aa3e93c1aa4fff7d073467106eb0ce486116_prof);

    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_816c7ec726376970800bb32a0c878565a917d97055325adf2bd8c4a5ebd21d02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_816c7ec726376970800bb32a0c878565a917d97055325adf2bd8c4a5ebd21d02->enter($__internal_816c7ec726376970800bb32a0c878565a917d97055325adf2bd8c4a5ebd21d02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 4
        $this->loadTemplate("FOSUserBundle:Group:new_content.html.twig", "FOSUserBundle:Group:new.html.twig", 4)->display($context);
        
        $__internal_816c7ec726376970800bb32a0c878565a917d97055325adf2bd8c4a5ebd21d02->leave($__internal_816c7ec726376970800bb32a0c878565a917d97055325adf2bd8c4a5ebd21d02_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Group:new.html.twig";
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
{% include \"FOSUserBundle:Group:new_content.html.twig\" %}
{% endblock fos_user_content %}
", "FOSUserBundle:Group:new.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/friendsofsymfony/user-bundle/Resources/views/Group/new.html.twig");
    }
}
