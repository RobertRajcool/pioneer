<?php

/* ::base.html.twig */
class __TwigTemplate_b09279bf68626a308ea8b9e9bb4c59688fbfd447f089ac03f36dd2a903aeedba extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_ae7f3bc70bcbdea1f4280fd73d48a33099dadb8b7b68191fc6b8a0c472a5e2ff = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ae7f3bc70bcbdea1f4280fd73d48a33099dadb8b7b68191fc6b8a0c472a5e2ff->enter($__internal_ae7f3bc70bcbdea1f4280fd73d48a33099dadb8b7b68191fc6b8a0c472a5e2ff_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "::base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
    <meta charset=\"UTF-8\" />
    <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    ";
        // line 6
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 7
        echo "    <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
    <script src=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("bundles/fosjsrouting/js/router.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 9
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("fos_js_routing_js", array("callback" => "fos.Router.setData"));
        echo "\"></script>
</head>
<body>
";
        // line 12
        $this->displayBlock('body', $context, $blocks);
        // line 13
        $this->displayBlock('javascripts', $context, $blocks);
        // line 14
        echo "</body>
</html>
";
        
        $__internal_ae7f3bc70bcbdea1f4280fd73d48a33099dadb8b7b68191fc6b8a0c472a5e2ff->leave($__internal_ae7f3bc70bcbdea1f4280fd73d48a33099dadb8b7b68191fc6b8a0c472a5e2ff_prof);

    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        $__internal_8360f943550b1c3ab25ed021e68bc3e3e14aeb1b910424520311af3918af54f3 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_8360f943550b1c3ab25ed021e68bc3e3e14aeb1b910424520311af3918af54f3->enter($__internal_8360f943550b1c3ab25ed021e68bc3e3e14aeb1b910424520311af3918af54f3_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Welcome!";
        
        $__internal_8360f943550b1c3ab25ed021e68bc3e3e14aeb1b910424520311af3918af54f3->leave($__internal_8360f943550b1c3ab25ed021e68bc3e3e14aeb1b910424520311af3918af54f3_prof);

    }

    // line 6
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_65795c9c81016afd395321dba083c6b37d09daddec20e46cd13bfba3c17ff695 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_65795c9c81016afd395321dba083c6b37d09daddec20e46cd13bfba3c17ff695->enter($__internal_65795c9c81016afd395321dba083c6b37d09daddec20e46cd13bfba3c17ff695_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_65795c9c81016afd395321dba083c6b37d09daddec20e46cd13bfba3c17ff695->leave($__internal_65795c9c81016afd395321dba083c6b37d09daddec20e46cd13bfba3c17ff695_prof);

    }

    // line 12
    public function block_body($context, array $blocks = array())
    {
        $__internal_0ca2f7e90470f0a14baf9cddc1e396133c301df822a9e2b809dc9091b014e091 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_0ca2f7e90470f0a14baf9cddc1e396133c301df822a9e2b809dc9091b014e091->enter($__internal_0ca2f7e90470f0a14baf9cddc1e396133c301df822a9e2b809dc9091b014e091_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_0ca2f7e90470f0a14baf9cddc1e396133c301df822a9e2b809dc9091b014e091->leave($__internal_0ca2f7e90470f0a14baf9cddc1e396133c301df822a9e2b809dc9091b014e091_prof);

    }

    // line 13
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_2272ad0c3cec51fd0574b7df8d41c13a55cd05a676309517acf1eed4b1568774 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_2272ad0c3cec51fd0574b7df8d41c13a55cd05a676309517acf1eed4b1568774->enter($__internal_2272ad0c3cec51fd0574b7df8d41c13a55cd05a676309517acf1eed4b1568774_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_2272ad0c3cec51fd0574b7df8d41c13a55cd05a676309517acf1eed4b1568774->leave($__internal_2272ad0c3cec51fd0574b7df8d41c13a55cd05a676309517acf1eed4b1568774_prof);

    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  100 => 13,  89 => 12,  78 => 6,  66 => 5,  57 => 14,  55 => 13,  53 => 12,  47 => 9,  43 => 8,  38 => 7,  36 => 6,  32 => 5,  26 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
<head>
    <meta charset=\"UTF-8\" />
    <title>{% block title %}Welcome!{% endblock %}</title>
    {% block stylesheets %}{% endblock %}
    <link rel=\"icon\" type=\"image/x-icon\" href=\"{{ asset('favicon.ico') }}\" />
    <script src=\"{{ asset('bundles/fosjsrouting/js/router.js') }}\"></script>
    <script src=\"{{ path('fos_js_routing_js', { callback: 'fos.Router.setData' }) }}\"></script>
</head>
<body>
{% block body %}{% endblock %}
{% block javascripts %}{% endblock %}
</body>
</html>
", "::base.html.twig", "/var/www/html/pioneer/pioneer-backend/app/Resources/views/base.html.twig");
    }
}
