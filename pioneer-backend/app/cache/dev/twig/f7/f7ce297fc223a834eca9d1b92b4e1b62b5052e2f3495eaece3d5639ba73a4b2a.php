<?php

/* @WebProfiler/Collector/router.html.twig */
class __TwigTemplate_dbb4919d611aaa989a95504a19b40fcbbc39b2651a5e2c2b29052f83fb015736 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/router.html.twig", 1);
        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_176c97cb92d94c0ceaa12caca447a5257f5350694626fcbc80937514abf53319 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_176c97cb92d94c0ceaa12caca447a5257f5350694626fcbc80937514abf53319->enter($__internal_176c97cb92d94c0ceaa12caca447a5257f5350694626fcbc80937514abf53319_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_176c97cb92d94c0ceaa12caca447a5257f5350694626fcbc80937514abf53319->leave($__internal_176c97cb92d94c0ceaa12caca447a5257f5350694626fcbc80937514abf53319_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_e13f20abb270a4276bd7c276268b2f4c2ce5022d74c15d178062514d70b494d8 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_e13f20abb270a4276bd7c276268b2f4c2ce5022d74c15d178062514d70b494d8->enter($__internal_e13f20abb270a4276bd7c276268b2f4c2ce5022d74c15d178062514d70b494d8_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_e13f20abb270a4276bd7c276268b2f4c2ce5022d74c15d178062514d70b494d8->leave($__internal_e13f20abb270a4276bd7c276268b2f4c2ce5022d74c15d178062514d70b494d8_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_ec92721b6c48de39cd137e7c19d19cfc396c2cf6a1dd3a0b35dfb0af0242c2e5 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ec92721b6c48de39cd137e7c19d19cfc396c2cf6a1dd3a0b35dfb0af0242c2e5->enter($__internal_ec92721b6c48de39cd137e7c19d19cfc396c2cf6a1dd3a0b35dfb0af0242c2e5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_ec92721b6c48de39cd137e7c19d19cfc396c2cf6a1dd3a0b35dfb0af0242c2e5->leave($__internal_ec92721b6c48de39cd137e7c19d19cfc396c2cf6a1dd3a0b35dfb0af0242c2e5_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_e6b18dca2d5fcd61ce29e7962e439f4f77712c2657f1879304dd3856b16b2ca6 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_e6b18dca2d5fcd61ce29e7962e439f4f77712c2657f1879304dd3856b16b2ca6->enter($__internal_e6b18dca2d5fcd61ce29e7962e439f4f77712c2657f1879304dd3856b16b2ca6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpKernelExtension')->renderFragment($this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("_profiler_router", array("token" => ($context["token"] ?? $this->getContext($context, "token")))));
        echo "
";
        
        $__internal_e6b18dca2d5fcd61ce29e7962e439f4f77712c2657f1879304dd3856b16b2ca6->leave($__internal_e6b18dca2d5fcd61ce29e7962e439f4f77712c2657f1879304dd3856b16b2ca6_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/router.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 13,  67 => 12,  56 => 7,  53 => 6,  47 => 5,  36 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@WebProfiler/Profiler/layout.html.twig' %}

{% block toolbar %}{% endblock %}

{% block menu %}
<span class=\"label\">
    <span class=\"icon\">{{ include('@WebProfiler/Icon/router.svg') }}</span>
    <strong>Routing</strong>
</span>
{% endblock %}

{% block panel %}
    {{ render(path('_profiler_router', { token: token })) }}
{% endblock %}
", "@WebProfiler/Collector/router.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/WebProfilerBundle/Resources/views/Collector/router.html.twig");
    }
}
