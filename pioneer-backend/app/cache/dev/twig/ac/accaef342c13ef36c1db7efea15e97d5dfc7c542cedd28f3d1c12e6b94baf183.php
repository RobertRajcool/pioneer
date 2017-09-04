<?php

/* TwigBundle:Exception:exception_full.html.twig */
class __TwigTemplate_4bc2bc7f8dbc2bfc3a37dbfd1a9ec1c3db86380b881811c142319994a012f417 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Twig/layout.html.twig", "TwigBundle:Exception:exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
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
        $__internal_4a12839010ec3e3a2d837ef1734694c59fbc4517d2a394064481665b28ad7bd6 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_4a12839010ec3e3a2d837ef1734694c59fbc4517d2a394064481665b28ad7bd6->enter($__internal_4a12839010ec3e3a2d837ef1734694c59fbc4517d2a394064481665b28ad7bd6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_4a12839010ec3e3a2d837ef1734694c59fbc4517d2a394064481665b28ad7bd6->leave($__internal_4a12839010ec3e3a2d837ef1734694c59fbc4517d2a394064481665b28ad7bd6_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_65627c3d170afc7767798b2f5bb95b428cdb467602124ce58dfee8200141827a = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_65627c3d170afc7767798b2f5bb95b428cdb467602124ce58dfee8200141827a->enter($__internal_65627c3d170afc7767798b2f5bb95b428cdb467602124ce58dfee8200141827a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_65627c3d170afc7767798b2f5bb95b428cdb467602124ce58dfee8200141827a->leave($__internal_65627c3d170afc7767798b2f5bb95b428cdb467602124ce58dfee8200141827a_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_094df17241d5e9f694e17ddf5bc685c7bf5f974f81188c3e684abbb8aad869ff = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_094df17241d5e9f694e17ddf5bc685c7bf5f974f81188c3e684abbb8aad869ff->enter($__internal_094df17241d5e9f694e17ddf5bc685c7bf5f974f81188c3e684abbb8aad869ff_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["exception"] ?? $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, ($context["status_code"] ?? $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, ($context["status_text"] ?? $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_094df17241d5e9f694e17ddf5bc685c7bf5f974f81188c3e684abbb8aad869ff->leave($__internal_094df17241d5e9f694e17ddf5bc685c7bf5f974f81188c3e684abbb8aad869ff_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_0b8337fca25baa7c651b48e785904036104600e2f15921ac900943ff364c7819 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_0b8337fca25baa7c651b48e785904036104600e2f15921ac900943ff364c7819->enter($__internal_0b8337fca25baa7c651b48e785904036104600e2f15921ac900943ff364c7819_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("@Twig/Exception/exception.html.twig", "TwigBundle:Exception:exception_full.html.twig", 12)->display($context);
        
        $__internal_0b8337fca25baa7c651b48e785904036104600e2f15921ac900943ff364c7819->leave($__internal_0b8337fca25baa7c651b48e785904036104600e2f15921ac900943ff364c7819_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
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

{% block head %}
    <link href=\"{{ absolute_url(asset('bundles/framework/css/exception.css')) }}\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
{% endblock %}

{% block title %}
    {{ exception.message }} ({{ status_code }} {{ status_text }})
{% endblock %}

{% block body %}
    {% include '@Twig/Exception/exception.html.twig' %}
{% endblock %}
", "TwigBundle:Exception:exception_full.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/TwigBundle/Resources/views/Exception/exception_full.html.twig");
    }
}
