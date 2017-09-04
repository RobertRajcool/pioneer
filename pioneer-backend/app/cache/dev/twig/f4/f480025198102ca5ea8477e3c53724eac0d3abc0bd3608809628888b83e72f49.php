<?php

/* WebProfilerBundle:Profiler:toolbar_redirect.html.twig */
class __TwigTemplate_d4c9b98120fb6ed06007fd65b17b96001b875851f12b4757ac300e17e205f48d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Twig/layout.html.twig", "WebProfilerBundle:Profiler:toolbar_redirect.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@Twig/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_f0220749e736d18aac729f0d0ae6255e508301deb0e0bd96cc22e6fda3c87096 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_f0220749e736d18aac729f0d0ae6255e508301deb0e0bd96cc22e6fda3c87096->enter($__internal_f0220749e736d18aac729f0d0ae6255e508301deb0e0bd96cc22e6fda3c87096_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "WebProfilerBundle:Profiler:toolbar_redirect.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_f0220749e736d18aac729f0d0ae6255e508301deb0e0bd96cc22e6fda3c87096->leave($__internal_f0220749e736d18aac729f0d0ae6255e508301deb0e0bd96cc22e6fda3c87096_prof);

    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        $__internal_4b6005dc2326f1a203abfd6667e1e06c2a59834e66d403603957b59fe7d67cf7 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_4b6005dc2326f1a203abfd6667e1e06c2a59834e66d403603957b59fe7d67cf7->enter($__internal_4b6005dc2326f1a203abfd6667e1e06c2a59834e66d403603957b59fe7d67cf7_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Redirection Intercepted";
        
        $__internal_4b6005dc2326f1a203abfd6667e1e06c2a59834e66d403603957b59fe7d67cf7->leave($__internal_4b6005dc2326f1a203abfd6667e1e06c2a59834e66d403603957b59fe7d67cf7_prof);

    }

    // line 5
    public function block_body($context, array $blocks = array())
    {
        $__internal_74d68211d32d834791e8cbae7cbda25e1c30e0823739ce0bc8664752684df54b = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_74d68211d32d834791e8cbae7cbda25e1c30e0823739ce0bc8664752684df54b->enter($__internal_74d68211d32d834791e8cbae7cbda25e1c30e0823739ce0bc8664752684df54b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 6
        echo "    <div class=\"sf-reset\">
        <div class=\"block-exception\">
            <h1>This request redirects to <a href=\"";
        // line 8
        echo twig_escape_filter($this->env, ($context["location"] ?? $this->getContext($context, "location")), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, ($context["location"] ?? $this->getContext($context, "location")), "html", null, true);
        echo "</a>.</h1>

            <p>
                <small>
                    The redirect was intercepted by the web debug toolbar to help debugging.
                    For more information, see the \"intercept-redirects\" option of the Profiler.
                </small>
            </p>
        </div>
    </div>
";
        
        $__internal_74d68211d32d834791e8cbae7cbda25e1c30e0823739ce0bc8664752684df54b->leave($__internal_74d68211d32d834791e8cbae7cbda25e1c30e0823739ce0bc8664752684df54b_prof);

    }

    public function getTemplateName()
    {
        return "WebProfilerBundle:Profiler:toolbar_redirect.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  57 => 8,  53 => 6,  47 => 5,  35 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@Twig/layout.html.twig' %}

{% block title 'Redirection Intercepted' %}

{% block body %}
    <div class=\"sf-reset\">
        <div class=\"block-exception\">
            <h1>This request redirects to <a href=\"{{ location }}\">{{ location }}</a>.</h1>

            <p>
                <small>
                    The redirect was intercepted by the web debug toolbar to help debugging.
                    For more information, see the \"intercept-redirects\" option of the Profiler.
                </small>
            </p>
        </div>
    </div>
{% endblock %}
", "WebProfilerBundle:Profiler:toolbar_redirect.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/WebProfilerBundle/Resources/views/Profiler/toolbar_redirect.html.twig");
    }
}
