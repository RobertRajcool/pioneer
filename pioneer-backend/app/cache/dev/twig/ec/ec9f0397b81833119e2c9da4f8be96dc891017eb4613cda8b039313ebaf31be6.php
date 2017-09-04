<?php

/* TwigBundle:Exception:exception_full.html.twig */
class __TwigTemplate_671b61c7b06e6c3e4fd9b425d12a38032e48ad6bbd509436cc5fd99c9e411d9c extends Twig_Template
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
        $__internal_b2eb99135a5eb4a0a29ffec5e95f33c84177415cd2d55dc51be1bcdd3d28c035 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_b2eb99135a5eb4a0a29ffec5e95f33c84177415cd2d55dc51be1bcdd3d28c035->enter($__internal_b2eb99135a5eb4a0a29ffec5e95f33c84177415cd2d55dc51be1bcdd3d28c035_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_b2eb99135a5eb4a0a29ffec5e95f33c84177415cd2d55dc51be1bcdd3d28c035->leave($__internal_b2eb99135a5eb4a0a29ffec5e95f33c84177415cd2d55dc51be1bcdd3d28c035_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_636d22f340f7c22b1173fcb828a48a39daa7c734c31afb8a0e976b62a290aaa9 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_636d22f340f7c22b1173fcb828a48a39daa7c734c31afb8a0e976b62a290aaa9->enter($__internal_636d22f340f7c22b1173fcb828a48a39daa7c734c31afb8a0e976b62a290aaa9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_636d22f340f7c22b1173fcb828a48a39daa7c734c31afb8a0e976b62a290aaa9->leave($__internal_636d22f340f7c22b1173fcb828a48a39daa7c734c31afb8a0e976b62a290aaa9_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_79a216ab00fd9a7ae08983907f01f87faae27237fd5944e21dd3869418a841d0 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_79a216ab00fd9a7ae08983907f01f87faae27237fd5944e21dd3869418a841d0->enter($__internal_79a216ab00fd9a7ae08983907f01f87faae27237fd5944e21dd3869418a841d0_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["exception"] ?? $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, ($context["status_code"] ?? $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, ($context["status_text"] ?? $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_79a216ab00fd9a7ae08983907f01f87faae27237fd5944e21dd3869418a841d0->leave($__internal_79a216ab00fd9a7ae08983907f01f87faae27237fd5944e21dd3869418a841d0_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_9e37a00b919afd267658ae4ea851e4cfbb412f97a1bbc17491095f3c4e7b3429 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_9e37a00b919afd267658ae4ea851e4cfbb412f97a1bbc17491095f3c4e7b3429->enter($__internal_9e37a00b919afd267658ae4ea851e4cfbb412f97a1bbc17491095f3c4e7b3429_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("@Twig/Exception/exception.html.twig", "TwigBundle:Exception:exception_full.html.twig", 12)->display($context);
        
        $__internal_9e37a00b919afd267658ae4ea851e4cfbb412f97a1bbc17491095f3c4e7b3429->leave($__internal_9e37a00b919afd267658ae4ea851e4cfbb412f97a1bbc17491095f3c4e7b3429_prof);

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
