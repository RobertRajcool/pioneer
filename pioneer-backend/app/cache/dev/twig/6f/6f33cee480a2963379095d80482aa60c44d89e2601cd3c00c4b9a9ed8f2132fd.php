<?php

/* WebProfilerBundle:Collector:router.html.twig */
class __TwigTemplate_feebd5016a5e340df26463542a283f892df7c84af6e0dae68bdc964a67f5cb60 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "WebProfilerBundle:Collector:router.html.twig", 1);
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
        $__internal_a156fde400ab96980b8061f2de007b730abdcf842f23dfbfb3dc9b4a400eb71c = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_a156fde400ab96980b8061f2de007b730abdcf842f23dfbfb3dc9b4a400eb71c->enter($__internal_a156fde400ab96980b8061f2de007b730abdcf842f23dfbfb3dc9b4a400eb71c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "WebProfilerBundle:Collector:router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_a156fde400ab96980b8061f2de007b730abdcf842f23dfbfb3dc9b4a400eb71c->leave($__internal_a156fde400ab96980b8061f2de007b730abdcf842f23dfbfb3dc9b4a400eb71c_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_0db854a7df614be52ef62fac312c375e03abc095ca124dc4815bd753c55bd91b = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_0db854a7df614be52ef62fac312c375e03abc095ca124dc4815bd753c55bd91b->enter($__internal_0db854a7df614be52ef62fac312c375e03abc095ca124dc4815bd753c55bd91b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_0db854a7df614be52ef62fac312c375e03abc095ca124dc4815bd753c55bd91b->leave($__internal_0db854a7df614be52ef62fac312c375e03abc095ca124dc4815bd753c55bd91b_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_7d3c5c17e67401a537ac24bc8bdd137dd2d0c6d3fb2f5738f67b34e2b0541d0c = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_7d3c5c17e67401a537ac24bc8bdd137dd2d0c6d3fb2f5738f67b34e2b0541d0c->enter($__internal_7d3c5c17e67401a537ac24bc8bdd137dd2d0c6d3fb2f5738f67b34e2b0541d0c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_7d3c5c17e67401a537ac24bc8bdd137dd2d0c6d3fb2f5738f67b34e2b0541d0c->leave($__internal_7d3c5c17e67401a537ac24bc8bdd137dd2d0c6d3fb2f5738f67b34e2b0541d0c_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_21cab7506a267b1f7bcb45f02410e50f458c10701f00d3962c8f1fd7a6d7ee4d = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_21cab7506a267b1f7bcb45f02410e50f458c10701f00d3962c8f1fd7a6d7ee4d->enter($__internal_21cab7506a267b1f7bcb45f02410e50f458c10701f00d3962c8f1fd7a6d7ee4d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpKernelExtension')->renderFragment($this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("_profiler_router", array("token" => ($context["token"] ?? $this->getContext($context, "token")))));
        echo "
";
        
        $__internal_21cab7506a267b1f7bcb45f02410e50f458c10701f00d3962c8f1fd7a6d7ee4d->leave($__internal_21cab7506a267b1f7bcb45f02410e50f458c10701f00d3962c8f1fd7a6d7ee4d_prof);

    }

    public function getTemplateName()
    {
        return "WebProfilerBundle:Collector:router.html.twig";
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
", "WebProfilerBundle:Collector:router.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/WebProfilerBundle/Resources/views/Collector/router.html.twig");
    }
}
