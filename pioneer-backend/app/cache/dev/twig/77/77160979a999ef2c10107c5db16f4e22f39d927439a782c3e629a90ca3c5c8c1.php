<?php

/* base.html.twig */
class __TwigTemplate_4e7df43d23b20bdbb03b82e54fccdc159dc7babf35eebe64c13c3dec6df33bc0 extends Twig_Template
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
        $__internal_a7d6d8fdaa1fd0abf15f713e881e17cf0c4c3aa7f481187848bd1a9519ed5b66 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_a7d6d8fdaa1fd0abf15f713e881e17cf0c4c3aa7f481187848bd1a9519ed5b66->enter($__internal_a7d6d8fdaa1fd0abf15f713e881e17cf0c4c3aa7f481187848bd1a9519ed5b66_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "base.html.twig"));

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
        
        $__internal_a7d6d8fdaa1fd0abf15f713e881e17cf0c4c3aa7f481187848bd1a9519ed5b66->leave($__internal_a7d6d8fdaa1fd0abf15f713e881e17cf0c4c3aa7f481187848bd1a9519ed5b66_prof);

    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        $__internal_2794085d6149cdcf6ef81bae9c9aef0b98bd82728549ec11c34336ef8376550c = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_2794085d6149cdcf6ef81bae9c9aef0b98bd82728549ec11c34336ef8376550c->enter($__internal_2794085d6149cdcf6ef81bae9c9aef0b98bd82728549ec11c34336ef8376550c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Welcome!";
        
        $__internal_2794085d6149cdcf6ef81bae9c9aef0b98bd82728549ec11c34336ef8376550c->leave($__internal_2794085d6149cdcf6ef81bae9c9aef0b98bd82728549ec11c34336ef8376550c_prof);

    }

    // line 6
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_e4b6bc8775c0e44c8b66924d3a0203a5c83c5cad5c6c01a259a7921d3566e6be = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_e4b6bc8775c0e44c8b66924d3a0203a5c83c5cad5c6c01a259a7921d3566e6be->enter($__internal_e4b6bc8775c0e44c8b66924d3a0203a5c83c5cad5c6c01a259a7921d3566e6be_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_e4b6bc8775c0e44c8b66924d3a0203a5c83c5cad5c6c01a259a7921d3566e6be->leave($__internal_e4b6bc8775c0e44c8b66924d3a0203a5c83c5cad5c6c01a259a7921d3566e6be_prof);

    }

    // line 12
    public function block_body($context, array $blocks = array())
    {
        $__internal_3309456418051c3f37322974b47653250e594423cfa2613f78fbe98b034b4a51 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_3309456418051c3f37322974b47653250e594423cfa2613f78fbe98b034b4a51->enter($__internal_3309456418051c3f37322974b47653250e594423cfa2613f78fbe98b034b4a51_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_3309456418051c3f37322974b47653250e594423cfa2613f78fbe98b034b4a51->leave($__internal_3309456418051c3f37322974b47653250e594423cfa2613f78fbe98b034b4a51_prof);

    }

    // line 13
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_2b8807e7342d9b05a047124eade6626b822743e79d8ce3d0b636e4549e0b432f = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_2b8807e7342d9b05a047124eade6626b822743e79d8ce3d0b636e4549e0b432f->enter($__internal_2b8807e7342d9b05a047124eade6626b822743e79d8ce3d0b636e4549e0b432f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_2b8807e7342d9b05a047124eade6626b822743e79d8ce3d0b636e4549e0b432f->leave($__internal_2b8807e7342d9b05a047124eade6626b822743e79d8ce3d0b636e4549e0b432f_prof);

    }

    public function getTemplateName()
    {
        return "base.html.twig";
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
", "base.html.twig", "/var/www/html/pioneer/pioneer-backend/app/Resources/views/base.html.twig");
    }
}
